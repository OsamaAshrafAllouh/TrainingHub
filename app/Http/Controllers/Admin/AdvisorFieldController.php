<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisor;
use App\Models\AdvisorField;
use Illuminate\Http\Request;

class AdvisorFieldController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:program-accept', ['only' => ['accept']]);
    }
    /**
     * Display a listing of the resource.
     */

    //Advisor Management - Accept or not-accept specific field to specific advisor
    public function updateStatus($id)
    {
        $advisorField = AdvisorField::find($id);
        $advisor = Advisor::where('id', $advisorField->advisor_id)->first();
        if ($advisor->is_approved == '1') {
            if (!$advisorField) {
                return response()->json(['message' => 'Advisor field not found'], 404);
            }

            $status = request()->input('status');

            // Update the status of the advisor field
            $advisorField->status = $status;
            $advisorField->save();

            return response()->json(['message' => $status . " the " . $advisorField->field->name . " to " . $advisorField->advisor->first_name . " Advisor", 'isAccepted' => true]);
        } else {
            return response()->json(['message' => "The " . $advisorField->advisor->first_name . " advisor not accepted", 'isAccepted' => false]);
        }
    }

}
