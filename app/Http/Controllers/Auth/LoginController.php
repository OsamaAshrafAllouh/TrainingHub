<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('password');
        $level = $this->determineUserLevel($request);

        if ($level === 1) {
            $credentials['email'] = $request->input('email');
        } elseif ($level === 2 || $level === 3) {
            $credentials['unique_id'] = $request->input('email');
        }

        return Auth::attempt($credentials, $request->filled('remember'));
    }

    protected function determineUserLevel(Request $request)
    {
        // Logic to determine the user's level based on the input fields
        $email = $request->input('email');

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 1; // Level 1 for email login
        }

        // Assuming trainee_id is numeric, you may need to adjust the validation logic as per your system
        if (is_numeric($email)) {
            return 2; // Level 2 for trainee_id login
        }

        return 3; // Level 3 for trainee_id login (fallback)
    }
}
