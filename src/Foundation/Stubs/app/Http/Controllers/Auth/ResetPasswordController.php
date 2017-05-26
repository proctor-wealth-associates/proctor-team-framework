<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view for the given token.
     * If no token is present, display the link request form.
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('pages.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
