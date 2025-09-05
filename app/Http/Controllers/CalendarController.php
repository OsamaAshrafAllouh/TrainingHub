<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\TrainingAttendance;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function view($id)
    {
        $program = TrainingProgram::find($id);
        $program =Program::where('id' , $program->program_id )->first();
        $programId = $program->id;
        $traineeId = \App\Models\Trainee::where('email', Auth()->user()->email)->value('id');

        $attendances = TrainingAttendance::where('program_id', $programId)
            ->where('trainee_id', $traineeId)
            ->get();
        return view('Trainee.calenderManagement.view', compact('program','attendances'));
    }
}
