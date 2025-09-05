<?php

namespace App\Http\Controllers;

use App\Models\TrainingAttendance;
use Illuminate\Http\Request;

class TrainingAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function addAttendance(Request $request)
    {
        $response = json_decode($request->input('program'), true);
        $name = $response['name'];
        $id = $response['id'];
        $start_date = $response['start_date'];
        $end_date = $response['end_date'];

        $traineeId = $request->input('trainee_id');
        $status = $request->input('status');
        $date = $request->input('date');


        if ($date < $start_date) {
            toastr()->error('Program  ' . $name . ' Not Start Yet !');
            return redirect()->back();

        } else if ($date > $end_date) {
            toastr()->error('Program  ' . $name . ' is Finished !');
            return redirect()->back();

        } else {
            // Check if the attendance record already exists
            $existingAttendance = TrainingAttendance::where('program_id', $id)
                ->where('trainee_id', $traineeId)
                ->where('date', $date)
                ->first();

            if ($existingAttendance) {
                // Attendance record already exists, update the status
                toastr()->success('Attendance today is Entered Previously!');
            } else {
                // Attendance record doesn't exist, create a new record
                $attendance = new TrainingAttendance();
                $attendance->program_id = $id;
                $attendance->trainee_id = $traineeId;
                $attendance->status = $status;
                $attendance->date = $date;
                $attendance->save();
                toastr()->success('Attendance to ' . $name . ' in ' . $date . ' Created Successfully!');

            }
        }
        // Return a response indicating success
        return redirect()->back();
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TrainingAttendance $trainingAttendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrainingAttendance $trainingAttendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrainingAttendance $trainingAttendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrainingAttendance $trainingAttendance)
    {
        //
    }
}
