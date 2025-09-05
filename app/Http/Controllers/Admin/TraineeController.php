<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\downloadUrtTrait;
use App\Mail\PendingProgramMail;
use App\Mail\TraineeCredentialsMail;
use App\Models\Advisor;
use App\Models\AdvisorField;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Program;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Google\Cloud\Storage\StorageClient;
use Spatie\Permission\Models\Role;

class TraineeController extends Controller
{

    use downloadUrtTrait;

    function __construct(){
        $this->middleware('permission:admin-trainee-list', ['only' => ['index','show']]);
        $this->middleware('permission:admin-trainee-accept', ['only' => ['accept']]);
        $this->middleware('permission:admin-trainee-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-trainee-delete', ['only' => ['destroy']]);
        $this->middleware('permission:admin-BillingIssues-change', ['only' => ['updateStatus']]);
        $this->middleware('permission:advisor-program-trainees', ['only' => ['showTraineesinProgram']]);
        $this->middleware('permission:advisor-program-trainees-list', ['only' => ['displayTrainees']]);
    }

    /**
     * Display a listing of the resource.
     */

    //Trainee Management - display View contain all Trainees & his documents and files stored in firebase
    public function index(){
        $trainees = Trainee::all();
        foreach ($trainees as $trainee) {
            $payment = Payment::where('id', $trainee->payment)->first();
            if ($payment == null) {
                $trainee->payment = 'not Selected';
            } else {
                $trainee->payment = $payment->name;
            }



        // Get the file paths for CV, certification, and other files
            $cvPath = $trainee->cv;
            $certificationPath = $trainee->certification;
            $otherFiles = json_decode($trainee->otherFile);


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
            $trainee->cv = $cvDownloadUrl;
            $trainee->certification = $certificationDownloadUrl;
            $trainee->otherFile = $otherFileDownloadUrls;

        }


        return view('Admin.TraineesManagement.index', ['trainees' => $trainees]);
    }

    //Trainee Management - display View contain all payment way to register new trainee
    public function create(){
        $payments =Payment::all();
        return view('Admin.TraineesManagement.create',compact('payments'));
    }

    //Trainee Management - Validate & Store trainee Information in database (Sql-NoSQL)
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'image' => 'nullable|mimes:jpeg,png|max:10240', //validate the file types and size
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:trainees|unique:users|max:255',
            'phone' => 'required|string|max:20',
            'education' => 'required|string|max:255',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'payment' => 'nullable|string',
            'language' => 'nullable|string|in:French,Arabic,English',
            'cv' => 'required|mimes:pdf,docx,jpeg,png|max:10240', //validate the file types and size
            'certification' => 'required|mimes:pdf,docx,jpeg,png|max:10240',
            'otherFile.*' => 'nullable|file|max:10240', // Adjust the maximum file size as needed

        ]);

        if (!$validator->fails()) {
            // Generate a unique ID
            try {
                DB::beginTransaction();
                $trainee = new Trainee();
                $trainee->first_name = $request->input('first_name');
                $trainee->last_name = $request->input('last_name');
                $trainee->email = $request->input('email');
                $trainee->phone = $request->input('phone');
                $trainee->education = $request->input('education');
                $trainee->gpa = $request->input('gpa');
                $trainee->address = $request->input('address');
                $trainee->city = $request->input('city');
                $trainee->payment = $request->input('payment');
                $trainee->language = $request->input('language');
                $trainee->password = Hash::make('123456');

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
                    $cvFile = $request->file('cv');
                    $cvPath = 'CVs/' . time() + rand(1, 10000000) . '.' . $cvFile->getClientOriginalName();
                    $test = $bucket->upload(
                        file_get_contents($cvFile),
                        [
                            'name' => $cvPath,
                        ]
                    );
                    $trainee->cv = $cvPath;

                }

                // Store Certification Files
                if ($request->hasFile('certification')) {
                    $certificationFile = $request->file('certification');

                    $certificationPath = 'Certifications/' . time() + rand(1, 10000000) . '.' . $certificationFile->getClientOriginalName();
                    $bucket->upload(
                        file_get_contents($certificationFile),
                        [
                            'name' => $certificationPath,
                        ]
                    );
                    $trainee->certification = $certificationPath;

                }

                // Store Other Files
                if ($request->hasFile('otherFile')) {
                    $otherFiles = $request->file('otherFile');

                    foreach ($otherFiles as $otherFile) {
                        $otherPath = 'otherFiles/' . time() + rand(1, 10000000) . '.' . $otherFile->getClientOriginalName();
                        $bucket->upload(
                            file_get_contents($otherFile),
                            [
                                'name' => $otherPath,
                            ]
                        );
                        $otherFilePaths[] = $otherPath;
                    }

                    // Convert file paths to JSON array and save them in the trainee model
                    $trainee->otherFile = json_encode($otherFilePaths);
                }



                $notification = Notification::create([
                    'message' => $trainee->first_name . ' is a new trainee registration',
                    'status' => 'unread',
                    'level' => 1,

                ]);

                $trainee->notification_id = $notification->id;
                $trainee->save();


                $user= User::create([
                    'name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                    'email' => $request->input('email'),
                    'password' => Hash::make('123456'),
                    'level' => 3,
                ]);


                $role = Role::where('name', 'trainee')->first(); // Assuming 'advisor' is the role name you want to assign
                $user->assignRole($role);

                DB::commit();


            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error($e);

            }
        }else{
            return response()->json(['errors' => $validator->errors()], 422);
        }



    }

    //send email contain unique ID and password and change status if first time or change activation of this advisor
    public function accept($id){
        $trainee = Trainee::find($id); // Find the user by ID
        $user = User::where('email', $trainee->email)->first(); // Find the trainee by email
        $unique_id = uniqid();
        if ($user->unique_id == null) {
            $trainee->is_approved = true;
            $trainee->save();

            $user->unique_id = $unique_id;
            $pass = Str::random(10);
            $user->password = Hash::make($pass);

            $user->save();
            Mail::to($user->email)->send(new TraineeCredentialsMail($user->unique_id, $pass));

            return response()->json(['message' =>'Trainee Is Active  & Mail Send Successfully with login data!']);


        } else {
            if ($trainee->is_approved) {
                $trainee->is_approved = false;
                $trainee->save();

                return response()->json(['message' => "Trainee Not Active Now"]);

            } else {
                $trainee->is_approved = true;
                $trainee->save();

                return response()->json(['message' => "Trainee Active Now"]);

            }
        }
    }

    //Trainee Management - Show specific trainee Information and their Documents & files
    public function show($id){
        $trainee = Trainee::findOrFail($id);
        // Get the file paths for CV, certification, and other files
        $cvPath = $trainee->cv;
        $certificationPath = $trainee->certification;
        $otherFiles = json_decode($trainee->otherFile);


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
        $trainee->cv = $cvDownloadUrl;
        $trainee->certification = $certificationDownloadUrl;
        $trainee->otherFile = $otherFileDownloadUrls;

//        Notification::where('id', $trainee->notification_id)->update(['status' => 'read']);
        return view('Admin.TraineesManagement.show', compact('trainee'));
    }

    //Advisor Management - delete specific advisor
    public function destroy($id)
    {
        Trainee::findOrFail($id)->delete();
        return response()->json(['message' => 'Trainee deleted.']);
    }

    //display trainee to specific advisor
    public function displayTrainees(){
        $advisorId = Advisor::where('email', Auth()->user()->email)->value('id');
        $programIds = Program::where('advisor_id', $advisorId)->pluck('id');

        $trainees = Trainee::whereHas('programs', function ($query) use ($programIds) {
            $query->whereIn('program_id', $programIds)
                ->where('status', 'accepted');
        })->with(['programs' => function ($query) use ($programIds) {
            $query->whereIn('program_id', $programIds)->where('status', 'accepted')->select('name');
        }])->get();

        return view('Advisor.TraineesManagement.index', compact('trainees'));
    }

    //Trainee Management - Show specific trainee Information and their Documents & files
    public function showTrainees($id){
        $trainee = Trainee::findOrFail($id);
        // Get the file paths for CV, certification, and other files
        $cvPath = $trainee->cv;
        $certificationPath = $trainee->certification;
        $otherFiles = json_decode($trainee->otherFile);


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
        $trainee->cv = $cvDownloadUrl;
        $trainee->certification = $certificationDownloadUrl;
        $trainee->otherFile = $otherFileDownloadUrls;

        Notification::where('id', $trainee->notification_id)->update(['status' => 'read']);
        return view('Advisor.TraineesManagement.show', compact('trainee'));
    }

    public function showTraineesinProgram($programId){
        // Retrieve the trainees associated with the program ID where status is accepted
        $trainees = Trainee::whereHas('programs', function ($query) use ($programId) {
            $query->where('program_id', $programId)
                ->where('status', 'accepted');
        })->get();

        $programName = Program::where('id', $programId)->value('name');

        foreach ($trainees as $trainee) {
            // Get the file paths for CV, certification, and other files
            $cvPath = $trainee->cv;
            $certificationPath = $trainee->certification;
            $otherFiles = json_decode($trainee->otherFile);


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
            $trainee->cv = $cvDownloadUrl;
            $trainee->certification = $certificationDownloadUrl;
            $trainee->otherFile = $otherFileDownloadUrls;

        }


        return view('Advisor.TraineesManagement.index', compact('trainees' , 'programName'));
    }

    //Training Management - edit profile
    public function save(Request $request){
        // Retrieve the advisor record
        $id=Trainee::where('email',Auth::user()->email)->value('id');
        $trainee = Trainee::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('images'), $imageName);
            $requestData = $request->except('image','field');
            $requestData['image'] = $imageName;
            $trainee->update($requestData);
        } else {
            $trainee->update($request->all());
        }

        // Update the advisor record with the submitted form data
        $trainee->first_name = $request->input('first_name');
        $trainee->last_name = $request->input('last_name');
        $trainee->education = $request->input('education');
        $trainee->address = $request->input('address');
        $trainee->payment = $request->input('payment');
        $trainee->city = $request->input('city');
        $trainee->language = $request->input('language');
        $trainee->phone = $request->input('phone');

        $trainee->save();


        toastr()->success('Trainee Information Updated Successfully!');


        // Redirect back or to a success page
        return redirect()->back();
    }

    //Training Management - make trainee pending in course he not paid for
    public function updateStatus(Request $request, $id){
        $trainee = Trainee::find($id);
        $Program_id=$request->input('program_id');
        $programTraining = TrainingProgram::where('id', $Program_id)->first();

        if ($trainee && $programTraining) {
            $programTraining->status = 'pending';
            $programTraining->send_email = 1;
            $programTraining->save();

            $program = Program::find($programTraining->program_id);

            // Send payment reminder email
            Mail::to($trainee->email)->send(new PendingProgramMail($program->name , $trainee->first_name ." " . $trainee->last_name ,$program->price));


            return response()->json(['message' => 'Trainee status updated to pending & Email Send ']);
        }

        return response()->json(['message' => 'Trainee or program training not found.'], 404);
    }
}
