<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Mail\AcceptMeetingMail;
use App\Mail\PendingProgramMail;
use App\Models\Advisor;
use App\Models\MeetingRequest;
use App\Models\Program;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Kreait\Firebase\Contract\Auth;
use DateTime;

class MeetingRequestController extends Controller
{
//    function __construct(){
//        $this->middleware('permission:advisor-meeting-list', ['only' => ['meetings']]);
//        $this->middleware('permission:advisor-meeting-accept', ['only' => ['update']]);
//        $this->middleware('permission:trainee-meeting-list', ['only' => ['index']]);
//        $this->middleware('permission:trainee-meeting-create', ['only' => ['store']]);
//    }

    public function index()
    {
        $id = Trainee::where('email', Auth()->user()->email)->value('id');
        $meetings = MeetingRequest::where('trainee_id', $id)->get();

        $programs = Program::whereIn('id', $meetings->pluck('program_id'))->get();

        foreach ($meetings as $meeting) {
            $program = $programs->firstWhere('id', $meeting->program_id);
            $advisor = Advisor::find($meeting->advisor_id);
            $meeting->program = $program;
            $meeting->advisor = $advisor;
        }

        $acceptedPrograms = TrainingProgram::with('program.advisor')
            ->where('trainee_id', $id)
            ->where('status', 'accepted')
            ->get();

        $distinctAdvisors = $acceptedPrograms->unique('program.advisor_id');

        return view('Trainee.MeetingManagement.index', compact('meetings', 'acceptedPrograms', 'distinctAdvisors'));
    }

    public function getProgramsByAdvisor($advisorId)
    {
        $programs = Program::where('advisor_id', $advisorId)->get();
        return response()->json($programs);
    }

    public function store(Request $request)
    {
        $advisorId = $request->input('advisor_id');
        $traineeId = Trainee::where('email', Auth()->user()->email)->value('id');
        $date = $request->input('date');
        $time = $request->input('time');
        $dateTime = DateTime::createFromFormat('H:i', $time);
        $hours = $dateTime->format('H');

        $advisorConflict = MeetingRequest::where('advisor_id', $advisorId)
            ->where('date', $date)
            ->whereRaw("DATE_FORMAT(time, '%H') = ?", [$hours])
            ->where('status', 'accepted')
            ->exists();

        // Check for conflicting meetings with the trainee
        $traineeConflict = MeetingRequest::where('trainee_id', $traineeId)
            ->where('date', $date)
            ->whereRaw("DATE_FORMAT(time, '%H') = ?", [$hours])
            ->where('status', 'accepted')
            ->exists();

        // If there are no conflicts, store the meeting request
        if (!$advisorConflict && !$traineeConflict) {
            // Create a new meeting request instance
            $meetingRequest = new MeetingRequest();
            $meetingRequest->trainee_id = $traineeId;
            $meetingRequest->advisor_id = $advisorId;
            $meetingRequest->program_id = $request->input('program_id');;
            $meetingRequest->date = $date;
            $meetingRequest->time = $time;

            // Save the meeting request
            $meetingRequest->save();

            // Redirect or show a success message
            toastr()->success('Meeting request to Advisor has been created successfully! Wait Response');
            return redirect()->route('meetings.index');
        } elseif ($traineeConflict) {
            toastr()->error('You have other meeting same hours with the selected time. Please choose a different time.');
            return redirect()->route('meetings.index');
        } else {
            toastr()->error('There is a conflict in same hours with the selected time. Please choose a different time.');
            return redirect()->route('meetings.index');
        }
    }

    public function meetings()
    {
        $id = Advisor::where('email', Auth()->user()->email)->value('id');
        $meetings = MeetingRequest::where('advisor_id', $id)->get();

        $programs = Program::whereIn('id', $meetings->pluck('program_id'))->get();

        foreach ($meetings as $meeting) {
            $program = $programs->firstWhere('id', $meeting->program_id);
            $trainee = Trainee::find($meeting->trainee_id);
            $meeting->program = $program;
            $meeting->trainee = $trainee;
        }

        $acceptedPrograms = TrainingProgram::with('program.advisor')
            ->where('trainee_id', $id)
            ->where('status', 'accepted')
            ->get();


        return view('Advisor.MeetingManagement.index', compact('meetings', 'acceptedPrograms'));
    }

    public function update(Request $request, $id){
        $status = $request->input('status');


        // Retrieve the meeting based on the $id
        $meeting = MeetingRequest::findOrFail($id);
        $trainee = Trainee::where('id', $meeting->trainee_id)->first();
        if ($status == 'accepted') {
            $time = $meeting->time;
            $dateTime = DateTime::createFromFormat('H:i:s', $time);
            $hours = (int)$dateTime->format('H');
            if ($dateTime !== false) {
                $advisorConflict = MeetingRequest::where('advisor_id', $meeting->advisor_id)
                    ->where('date', $meeting->date)
                    ->whereRaw("DATE_FORMAT(time, '%H') = ?", [$hours])
                    ->where('status', 'accepted')
                    ->exists();


                // Check for conflicting meetings with the trainee
                $traineeConflict = MeetingRequest::where('trainee_id', $meeting->trainee_id)
                    ->where('date', $meeting->date)
                    ->whereRaw("DATE_FORMAT(time, '%H') = ?", [$hours])
                    ->where('status', 'accepted')
                    ->exists();


                if (!$advisorConflict && !$traineeConflict) {
                    $logFileName = 'advisor_' . $meeting->advisor_id . '.log';
                    Log::info('Advisor scheduled meeting with trainee: ' .  $meeting->trainee_id . ' at ' .$meeting->date . " ".$meeting->time.date('Y-m-d H:i:s'));

                    $meeting->status = $status;
                    $meeting->save();

                    $advisorName = $meeting->advisor->first_name . " " . $meeting->advisor->last_name; // Get the name of the advisor
                    $programName = $meeting->program->name; // Get the name of the program
                    $date = $meeting->date; // Get the date
                    $time = $meeting->time; // Get the time

                    Mail::to($trainee->email)->send(new AcceptMeetingMail($advisorName, $programName, $date, $time));

                    toastr()->success('Meeting status updated successfully & mail send');

                } elseif ($traineeConflict) {
                    $meeting->status = 'rejected';
                    $meeting->save();
                    toastr()->error('Another Advisor Accept trainee meeting you cant accept in this time.');
                } else {
                    toastr()->error('There is a conflict in same hours with the selected time. Please choose a different time.');
                }
            }
        } elseif ($status == 'rejected') {
            $meeting->status = $status;
            $meeting->save();
            toastr()->warning('You Reject this meeting');

        }


        return redirect()->back();

    }


}
