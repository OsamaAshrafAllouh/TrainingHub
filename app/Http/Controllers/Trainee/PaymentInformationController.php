<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\PaymentInformation;
use App\Models\Trainee;
use App\Models\TrainingProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function pay(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|exists:payment_informations,card_number',
            'amount' => 'required|numeric',
        ]);

        // If validation fails, return back with the validation errors
        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->route('trainees-programs.index');
        }

        // Retrieve the authenticated trainee's payment information
        $trainee = Trainee::where('email', auth()->user()->email)->with('paymentInformation')->first();

        // Update the payment status and amount
        if ($trainee) {
            $trainee->paymentInformation->amount -= $request->input('amount');
            $trainee->paymentInformation->save();
            // Update the program's payment status to 'paid'
            // Assuming you have a relationship between programs and payment_informations
            if ($request->input('amount') == $request->input('price')) {

                $program = TrainingProgram::findOrFail($request->input('program_ids'));
                $program->payment_status = 'paid';
                $program->save();
                toastr()->success('Payment successful.');
                return redirect()->route('trainees-programs.index');

            } else {
                toastr()->error('You should pay all fees');
                return redirect()->route('trainees-programs.index');

            }
            // Redirect or return a response with a success message
        }

        // If payment information doesn't exist, redirect or return a response with an error message
        return redirect()->back()->with('error', 'Payment information not found.');
    }


    public function store(Request $request)
    {
        $trainee_id = Trainee::where('email', Auth()->user()->email)->value('id');

        $currentYear = date('Y');

        $validator = Validator::make($request->all(), [
            'card_number' => 'required|unique:payment_informations|string|size:7',
            'cvv' => 'required|string|size:3',
            'ex_month' => 'required',
            'ex_year' => 'required|numeric|min:' . $currentYear,
        ]);

        if ($validator->fails()) {
            toastr()->error($validator->errors()->first());
            return redirect()->route('trainees-programs.index');

        }

        try {
            $paymentInformation = new PaymentInformation();
            $paymentInformation->card_number = $request->input('card_number');
            $paymentInformation->cvv = $request->input('cvv');
            $paymentInformation->ex_month = $request->input('ex_month');
            $paymentInformation->ex_year = $request->input('ex_year');
            $paymentInformation->trainee_id = $trainee_id;
            $paymentInformation->save();

            // Perform any additional actions or validations if needed
            toastr()->success('Payment information stored successfully');
            return redirect()->route('trainees-programs.index');
        } catch (\Exception $e) {
            toastr()->error('Error occurred. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentInformation $paymentInformation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentInformation $paymentInformation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentInformation $paymentInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentInformation $paymentInformation)
    {
        //
    }
}
