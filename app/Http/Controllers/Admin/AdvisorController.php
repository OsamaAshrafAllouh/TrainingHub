<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\downloadUrtTrait;
use App\Mail\PendingProgramMail;
use App\Mail\TraineeCredentialsMail;
use App\Models\Advisor;
use App\Models\AdvisorField;
use App\Models\Field;
use App\Models\Notification;
use App\Models\User;
use Google\Cloud\Storage\StorageClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdvisorController extends Controller
{
    use downloadUrtTrait;

    function __construct(){
        $this->middleware('permission:admin-advisor-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:admin-advisor-accept', ['only' => ['accept']]);
        $this->middleware('permission:admin-advisor-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-advisor-delete', ['only' => ['destroy']]);
        $this->middleware('permission:advisor-profile-edit', ['only' => ['save']]);
    }
    /**
     * Display a listing of the resource.
     */

    //Advisor Management - display View contain all advisors & his documents and files stored in firebase
    public function index(){
        $advisors = Advisor::with('fields')->get();

        foreach ($advisors as $advisor) {
            // Get the file paths for CV, certification, and other files
            $cvPath = $advisor->cv;
            $certificationPath = $advisor->certification;
            $otherFiles = json_decode($advisor->otherFile);


            // Generate download links or display the files
            $cvDownloadUrl = $this->generateDownloadUrl($cvPath);
            $certificationDownloadUrl = $this->generateDownloadUrl($certificationPath);
            $otherFileDownloadUrls = [];


            // Handle the case when $otherFiles is empty or null
            if (!empty($otherFiles)) {
                foreach ($otherFiles as $otherFile) {
                    $otherFileDownloadUrls[] = $this->generateDownloadUrl($otherFile);
                }
            }

            // Assign the download URLs to the trainee object
            $advisor->cv = $cvDownloadUrl;
            $advisor->certification = $certificationDownloadUrl;
            $advisor->otherFile = $otherFileDownloadUrls;

        }
        return view('Admin.AdvisorsManagement.index', ['advisors' => $advisors]);
    }

    //Advisor Management - display View contain all field to register new advisor
    public function create(){
        $fields =Field::all();
        return view('Admin.AdvisorsManagement.create',compact('fields'));
    }

    //Advisor Management - Validate & Store advisor Information in database (Sql-NoSQL)
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'image' => 'nullable|mimes:jpeg,png|max:10240', //validate the file types and size
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:advisors|unique:users|max:255',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment' => 'nullable|string|in:Card,PayPal,Bank',
            'language' => 'nullable|string|in:French,Arabic,English',
            'cv' => 'required|mimes:pdf,docx|max:10240',
            'certification' => 'required|mimes:pdf,docx,jpeg,png|max:10240',
            'otherFile.*' => 'nullable|file|max:10240',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            DB::beginTransaction();
            $advisor = new Advisor();
            $advisor->first_name = $request->input('first_name');
            $advisor->last_name = $request->input('last_name');
            $advisor->email = $request->input('email');
            $advisor->phone = $request->input('phone');
            $advisor->education = $request->input('education');
            $advisor->address = $request->input('address');
            $advisor->city = $request->input('city');
            $advisor->language = $request->input('language');
            $advisor->password = Hash::make('123456');

            $firebaseCredentialsPath = storage_path(env('FIREBASE_CREDENTIALS_PATH'));

            // Initialize Google Cloud Storage with proper SSL configuration
            $storage = new StorageClient([
                'projectId' => 'training-application-707f6',
                'keyFilePath' => $firebaseCredentialsPath,
                'httpOptions' => [
                    'verify' => 'C:\php\php-8.2.29-nts-Win32-vs16-x64\extras\ssl\cacert.pem', // Use CA bundle
                    'timeout' => 60,
                ],
            ]);

            $bucket = $storage->bucket('training-application-707f6.appspot.com');

            // Store CV Files
            if ($request->hasFile('cv')) {
                try {
                    $cvFile = $request->file('cv');
                    $cvPath = 'CVs/' . time() . '_' . rand(1, 10000000) . '_' . $cvFile->getClientOriginalName();

                    $bucket->upload(
                        file_get_contents($cvFile),
                        [
                            'name' => $cvPath,
                        ]
                    );

                    $advisor->cv = $cvPath;
                    Log::info('CV file uploaded successfully', ['path' => $cvPath]);
                } catch (\Exception $e) {
                    Log::error('Failed to upload CV file to Google Cloud Storage', ['error' => $e->getMessage()]);
                    throw new \Exception('Failed to upload CV file: ' . $e->getMessage());
                }
            }

            // Store Certification Files
            if ($request->hasFile('certification')) {
                try {
                    $certificationFile = $request->file('certification');
                    $certificationPath = 'Certifications/' . time() . '_' . rand(1, 10000000) . '_' . $certificationFile->getClientOriginalName();
                    Log::info('Uploading certification file', ['path' => $certificationPath]);

                    $bucket->upload(
                        file_get_contents($certificationFile),
                        [
                            'name' => $certificationPath,
                        ]
                    );

                    $advisor->certification = $certificationPath;
                    Log::info('Certification file uploaded successfully', ['path' => $certificationPath]);
                } catch (\Exception $e) {
                    Log::error('Failed to upload certification file to Google Cloud Storage', ['error' => $e->getMessage()]);
                    throw new \Exception('Failed to upload certification file: ' . $e->getMessage());
                }
            }

            // Store Other Files
            if ($request->hasFile('otherFile')) {
                try {
                    $otherFiles = $request->file('otherFile');
                    $otherFilePaths = [];

                    foreach ($otherFiles as $otherFile) {
                        $otherPath = 'otherFiles/' . time() . '_' . rand(1, 10000000) . '_' . $otherFile->getClientOriginalName();
                        Log::info('Uploading other file', ['path' => $otherPath]);

                        $bucket->upload(
                            file_get_contents($otherFile),
                            [
                                'name' => $otherPath,
                            ]
                        );
                        $otherFilePaths[] = $otherPath;
                    }

                    // Convert file paths to JSON array and save them in the trainee model
                    $advisor->otherFile = json_encode($otherFilePaths);
                    Log::info('Other files uploaded successfully', ['count' => count($otherFilePaths)]);
                } catch (\Exception $e) {
                    Log::error('Failed to upload other files to Google Cloud Storage', ['error' => $e->getMessage()]);
                    throw new \Exception('Failed to upload other files: ' . $e->getMessage());
                }
            }

            Log::info('advisor_store',[
                'advisor' => $advisor,
            ]);


            $notification = Notification::create([
                'message' => $advisor->first_name . ' is a new Advisor registration',
                'status' => 'unread',
                'level' => 1,

            ]);

            $advisor->notification_id = $notification->id;
            $advisor->save();


            //Store each field to this advior then accept or not-accept
            $selectedFieldIds = $request->input('field');
            foreach ($selectedFieldIds as $fieldId) {
                AdvisorField::create([
                    'advisor_id' => $advisor->id,
                    'field_id' => $fieldId,
                ]);
            }

            $user= User::create([
                'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'level'=> '2',
                'email' => $request->input('email'),
                'password' => Hash::make('123456'),
            ]);

            $role = Role::where('name', 'advisor')->first(); // Assuming 'advisor' is the role name you want to assign
            $user->assignRole($role);

            DB::commit();

            toastr()->success('Advisor created successfully!');
            return redirect('/login');

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }

    }

     //send email contain  unique ID and password and change status if first time or change activation of this advisor
    public function accept($id){
        $advisor = Advisor::find($id); // Find the user by ID
        $user = User::where('email', $advisor->email)->first(); // Find the trainee by email
        if ($user->unique_id == null) {
            $advisor->is_approved = true;
            $advisor->save();


            //by defualt accept all field he specific it in registeration
            $advisor = Advisor::find($id);
            $fields = $advisor->fields;
            foreach ($fields as $field) {
                AdvisorField::where('advisor_id', $id)->where('field_id', $field->id)->update(['status' => 'accept']);
            }

            $advisor_id = uniqid();
            $user->unique_id = $advisor_id;
            $pass = Str::random(10);
            $user->password = Hash::make($pass);
            $user->save();

            Mail::to($user->email)->send(new TraineeCredentialsMail($user->unique_id, $pass));
            return response()->json(['message' =>'Advisor Is Active  & Mail Send Successfully with login data!']);


        } else {
            if ($advisor->is_approved) {
                $advisor->is_approved = false;
                $advisor->save();

                return response()->json(['message' => "Advisor Not Active Now"]);

            } else {
                $advisor->is_approved = true;
                $advisor->save();

                return response()->json(['message' => "Advisor Active Now"]);

            }
        }
    }

    //Advisor Management - Show specific advisor Information and their Documents & files
    public function show($id){

        $advisor = Advisor::findOrFail($id);
        $cvPath = $advisor->cv;
        $certificationPath = $advisor->certification;
        $otherFiles = json_decode($advisor->otherFile);


        // Generate download links or display the files
        $cvDownloadUrl = $this->generateDownloadUrl($cvPath);
        $certificationDownloadUrl = $this->generateDownloadUrl($certificationPath);
        $otherFileDownloadUrls = [];


        // Handle the case when $otherFiles is empty or null
        if (!empty($otherFiles)) {
            foreach ($otherFiles as $otherFile) {
                $otherFileDownloadUrls[] = $this->generateDownloadUrl($otherFile);
            }
        }

        // Assign the download URLs to the trainee object
        $advisor->cv = $cvDownloadUrl;
        $advisor->certification = $certificationDownloadUrl;
        $advisor->otherFile = $otherFileDownloadUrls;
       Notification::where('id', $advisor->notification_id)->update(['status' => 'read']);
        return view('Admin.AdvisorsManagement.show', compact('advisor'));
    }

    //Advisor Management - get all Advisor in specific Fields
    public function getAdvisors($fieldId){
        $field = Field::find($fieldId);
        $advisors = $field->advisors()->wherePivot('status', 'accept')->get();
        return response()->json($advisors);
    }

    //Advisor Management - display View contain all advisors and their field to accept or reject
    public function advisorsFields(){
        $advisor_fields= AdvisorField::all();
        return view('Admin.AdvisorsManagement.advisors_fields', compact('advisor_fields'));

    }

    //Advisor Management - delete specific advisor
    public function destroy($id)
    {
        Advisor::findOrFail($id)->delete();
        return response()->json(['message' => 'Advisor deleted.']);
    }

    public function save(Request $request)
    {
        // Retrieve the advisor record
        $id=Advisor::where('email',Auth::user()->email)->value('id');
        $advisor = Advisor::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imageName);
            $requestData = $request->except('image','field');
            $requestData['image'] = $imageName;
            $advisor->update($requestData);
        } else {
            $advisor->update($request->except('field'));
        }

        // Update the advisor record with the submitted form data
        $advisor->first_name = $request->input('first_name');
        $advisor->last_name = $request->input('last_name');
        $advisor->education = $request->input('education');
        $advisor->address = $request->input('address');
        $advisor->city = $request->input('city');
        $advisor->language = $request->input('language');
        $advisor->phone = $request->input('phone');

        $advisor->save();

        // Save the new advisor fields
        $selectedFieldIds = $request->input('field');
        foreach ($selectedFieldIds as $fieldId) {
            AdvisorField::create([
                'advisor_id' => $advisor->id,
                'field_id' => $fieldId,
            ]);
        }

        toastr()->success('Advisor Information Updated Successfully!');


        // Redirect back or to a success page
        return redirect()->back();
    }
}
