<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\TraineeCredentialsMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use GuzzleHttp\Client;

class SocialAuthController extends Controller
{
    public function __construct()
    {
        // Configure Guzzle to handle SSL issues in development
        $client = new Client([
            'verify' => false, // Disable SSL verification for development
            'timeout' => 30,
        ]);

        // Set the custom client for Socialite
        Socialite::driver('google')->setHttpClient($client);
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return with error message for debugging
            return redirect('/login')->with('error', 'OAuth Error: ' . $e->getMessage());
        }

        $existingUser = User::where('google_id', $user->id)->first();

        if ($existingUser) {
            Auth::login($existingUser, true);
            return redirect('/home'); // Redirect to home dashboard after successful login
        } else {
            $password = '123456'; // Default password for new users
            $unique_id = 'T' . uniqid(); // Generate unique ID with T prefix for Trainee

            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'google_id' => $user->id,
                'unique_id' => uniqid(),
                'password' => Hash::make($password),
            ]);

            // Send email with login credentials including unique_id
            try {
                Mail::to($newUser->email)->send(new TraineeCredentialsMail($unique_id, $password));
            } catch (\Exception $e) {
                \Log::error('Failed to send credentials email: ' . $e->getMessage());
                // Continue with login even if email fails
            }

            Auth::login($newUser, true);
            return redirect('/home')->with('success', 'تم إنشاء حسابك بنجاح! تم إرسال بيانات تسجيل الدخول إلى بريدك الإلكتروني.'); // Redirect to home dashboard after successful registration
        }
    }
}
