<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Http\Request;
use Pusher\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{


    function __construct(){
        $this->middleware('permission:admin-payment-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:admin-payment-create', ['only' => ['store','create']]);
        $this->middleware('permission:admin-payment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:admin-payment-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */

    //Payment Ways Management -  display View contain all Payment way Available
    public function index(){
        $payments = Payment::all();
        return view('Admin.PaymentsManagement.index', compact('payments'));
    }

    //Payment Ways Management - Validate & Store Payment Way
    public function store(Request $request){
        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:50',
        ]);
        if (!$validator->fails()) {
            Payment::create($request->all());
            toastr()->success('Payment Way Created Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('payments.index');
    }

    //Payment Ways Management - Validate & Update Payment Way
    public function update(Request $request, $id){
        $validator = Validator($request->all(), [
            'name' => 'required|min:3|max:50',
        ]);


        if (!$validator->fails()) {
            Payment::query()->find($id)->update($request->all());
            toastr()->success('Payment Way Updated Successfully!');
        } else {
            toastr()->error($validator->getMessageBag()->first());
        }
        return redirect()->route('payments.index');
    }

    //Payment Ways Management - Delete Specific Payment Way
    public function destroy($id){
        Payment::findOrFail($id)->delete();
        return response()->json(['message' => 'Tier deleted.']);
    }


}
