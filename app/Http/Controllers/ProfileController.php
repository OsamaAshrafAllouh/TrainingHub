<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\downloadUrtTrait;
use App\Models\Advisor;
use App\Models\Field;
use App\Models\Payment;
use App\Models\Trainee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use downloadUrtTrait;
    //All Actors - display View To change Password
    public function password()
    {
        return view('Admin.updatePassword');
    }

    //All Actors - Validate &  change Password
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator($request->all(), [
            'oldPassword' => 'required',
            'password' => 'required|string|confirmed',
        ]);

        if ($validator->fails()) {
            if ($validator->errors()->has('password')) {
                return response()->json(['message' => $validator->errors()->first('password')], 422);
            } else {
                return response()->json(['message' => 'All fields should be entered'], 422);
            }
        } else {
            // Check if the previous password matches the one stored in the database
            if (!Hash::check($request->input('oldPassword'), $user->password)) {
                return response()->json(['message' => 'Previous password is incorrect'], 422);
            } else {
                // Update the password
                $user->password = Hash::make($request->input('password'));
                $user->save();
                return response()->json(['message' => 'Password updated successfully']);
            }
        }
    }

    public function profile(){
        // Check if the user is authenticated
        if (Auth::check()) {
            // User is authenticated
            // Access the authenticated user's level or any other data
            $user = Auth::user();
            $level = $user->level;

            // Perform actions based on the user's level
            if ($level === '1') {
            } elseif ($level === '2') {
                $fields =Field::all();

                $id=Advisor::where('email',Auth::user()->email)->value('id');
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


                return view('Profile.Advisor' , compact('advisor','fields'));

            } elseif ($level === '3') {
                $payments =Payment::all();

                $id=Trainee::where('email',Auth::user()->email)->value('id');
                $trainee = Trainee::findOrFail($id);
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

                return view('Profile.Trainee' , compact('trainee','payments'));
            }

            // Return the appropriate response
            return response()->json(['message' => 'Authenticated user with level: ' . $level]);
        }

        // User is not authenticated
        return response()->json(['message' => 'User not authenticated']);
    }
}
