<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainee;

class BillingController extends Controller
{

    function __construct(){
        $this->middleware('permission:admin-BillingIssues-List', ['only' => ['index']]);
    }

    //Advisor Management - display View contain all trainees and their billing issues
    public function index()
    {
        $trainees = Trainee::join('training_programs', 'trainees.id', '=', 'training_programs.trainee_id')
            ->join('programs', 'training_programs.program_id', '=', 'programs.id')
            ->select('training_programs.id as program_id','training_programs.send_email','trainees.id','trainees.first_name','trainees.last_name', 'programs.name as program_name','training_programs.payment_status')
            ->where('training_programs.payment_status', 'unpaid')
            ->where('programs.type', 'paid')
            ->get();


        return view('Admin.BillingsManagement.trainees-billing', compact('trainees'));

    }
}
