<?php

namespace App\Http\Controllers\Auth;

use Elegon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        $invite = session('invite_token') 
            ? Elegon::invite()->findByToken(session('invite_token')) 
            : null;

        return view('pages.auth.login', compact('invite'));
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($teamId = session('joined_team')) {
            session()->forget('joined_team');
            return redirect()->route('team.show', $teamId);
        }

        //
    }
}
