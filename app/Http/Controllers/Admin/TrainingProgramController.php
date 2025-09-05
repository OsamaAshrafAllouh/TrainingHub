<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Trainee\PaymentInformationController;
use App\Http\Controllers\Traits\downloadUrtTrait;
use App\Models\Advisor;
use App\Models\Field;
use App\Models\Payment;
use App\Models\PaymentInformation;
use App\Models\Program;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Database\Factories\TraineeProgramFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingProgramController extends Controller
{


//    function __construct(){
//
//        $this->middleware('permission:admin-program-alltrainee', ['only' => ['alltrainee']]);
//        $this->middleware('permission:trainee-training-program-join', ['only' => ['create','store']]);
//        $this->middleware('permission:trainee-training-program-accepted', ['only' => ['displayAcceptedProgram']]);
//        $this->middleware('permission:trainee-training-program-all', ['only' => ['index']]);
//    }

    use downloadUrtTrait;
    /**
     * Display a listing of the resource.
     */

    //Training Program Request - display all trainee request to apply in programs
    public function index()
    {
        $fields = Field::all();
        $traineeId = Trainee::where('email', Auth::user()->email)->value('id');// Assuming the trainee's ID is stored in the 'id' field of the user model

        $programs = TrainingProgram::where('trainee_id', $traineeId)->get();
        foreach ($programs as $program) {
            $program->program_name = Program::where('id', $program->program_id)->value('name');
            $fname = Advisor::where('id', $program->program->advisor_id)->value('first_name');
            $lname = Advisor::where('id', $program->program->advisor_id)->value('last_name');
            $program->advisor = $fname . " " . $lname;
            $program->program_type = Program::where('id', $program->program_id)->value('type');
            $program->price = Program::where('id', $program->program_id)->value('price');
            $program->payment_status = $program->payment_status === 'paid';
        }


        $paymentInformation = PaymentInformation::where('trainee_id', $traineeId)->exists();

        return view('Trainee.ApplyProgramsManagement.index', compact('fields', 'programs','paymentInformation'));
    }

    //Training Program Request - display all trainees request to manager to accept or not
    public function requests()
    {
        $programs = TrainingProgram::all();
        foreach ($programs as $program) {
            $program->program_name = Program::where('id', $program->program_id)->value('name');

            $fname = Advisor::where('id', $program->program->advisor_id)->value('first_name');
            $lname = Advisor::where('id', $program->program->advisor_id)->value('last_name');
            $program->advisor = $fname . " " . $lname;

            $trainee = Trainee::find($program->trainee_id);
            $program->trainee_name = $trainee->first_name . " " . $trainee->last_name;

            $program->program_type = Program::where('id', $program->program_id)->value('type');
        }

        return view('Admin.TrainingProgramManagement.index', compact('programs'));
    }

    public function create()
    {
        $fields = Field::all();
        return view('Trainee.ApplyProgramsManagement.index', compact('fields'));
    }

    public function store(Request $request)
    {
        $traineeId = Trainee::where('email', Auth::user()->email)->first();

        // Check if the trainee has already applied for the program
        $existingProgram = TrainingProgram::where('trainee_id', $traineeId->id)
            ->where('program_id', $request->input('program_id'))
            ->first();

        if ($existingProgram) {
            toastr()->warning('You have already applied for this program.');
            return redirect()->route('trainees-programs.index');
        }

        $traineeProgram = new TrainingProgram();
        $traineeProgram->trainee_id = $traineeId->id;
        $traineeProgram->program_id = $request->input('program_id');
        $traineeProgram->status = 'pending';
        $traineeProgram->save();

        $program = Program::find($request->input('program_id'));

        if ($program->type == 'free') {
            toastr()->success('The application to join the program has been transferred to the Manager. Please await a response');
        } else {
            toastr()->warning('Program is paid you showed pay fees ');

        }

        return redirect()->route('trainees-programs.index');


    }

    //Training Program Request - display all trainee accepted request
    public function displayAcceptedProgram()
    {
        // Get the authenticated trainee
        $trainee_id = Trainee::where('email', Auth::user()->email)->value('id');

        // Get the accepted training program for the trainee
        $programs = TrainingProgram::with('program')->where('trainee_id', $trainee_id)
            ->where('status', 'accepted')
            ->get();

        if ($programs->count() > 0) {
            // If programs exist, pass them to the view
            return view('Trainee.ApplyProgramsManagement.program', compact('programs'));
        } else {
            // If no accepted program exists, you can handle the case accordingly
            return view('Trainee.ApplyProgramsManagement.program', compact('programs'));
        }
    }

    public function getAdvisor(Request $request)
    {
        $programId = $request->input('program_id');
        $advisorId = Program::where('id', $programId)->value('advisor_id');
        $advisorName = Advisor::where('id', $advisorId)->value('first_name') . ' ' . Advisor::where('id', $advisorId)->value('last_name');
        return $advisorName;
    }

    public function update(Request $request, $id)
    {
        $programId = $request->input('program_id');
        $status = $request->input('status');

        $program = TrainingProgram::findOrFail($id);


        // Check if program number is greater than 0
        if ($program->program->number <= 0) {
            toastr()->error('Program is already full.');
            return redirect()->back();
        }

        // Check if program is paid and trainee has paid for it
        if ($program->program->type === 'paid') {
            $trainee_id = Trainee::where('email', Auth()->user()->email)->value('id');

            $trainingProgram = TrainingProgram::where('trainee_id', $trainee_id)
                ->where('program_id', $programId)
                ->where('payment_status', 'paid')
                ->first();

            toastr()->warning('Trainee not paid for this program.');
        }

        // Update the number/capacity of the program
        $program->program->number = ($program->program->number - 1);
        $program->program->save(); // Save the updated value
        // Update the status of the program
        $program->status = $status;
        $program->save();

        toastr()->success('Program status updated successfully.');

        return redirect()->back();

    }

    public function alltrainee($id)
    {
        // Retrieve the program with its related trainees and their statuses
        $trainees = TrainingProgram::with('trainee')->where('program_id', $id)->where('status' , 'accepted')->get();

        foreach ($trainees as $trainee) {

            // Get the file paths for CV, certification, and other files
            $cvPath = $trainee->trainee->cv;
            $certificationPath = $trainee->trainee->certification;
            $otherFiles = json_decode($trainee->trainee->otherFile);


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
            $trainee->trainee->cv = $cvDownloadUrl;
            $trainee->trainee->certification = $certificationDownloadUrl;
            $trainee->trainee->otherFile = $otherFileDownloadUrls;

        }

        // Pass the $program variable to the view or perform any other operations
        return view('Admin.ProgramsManagement.trainees', compact('trainees'));

    }
}
