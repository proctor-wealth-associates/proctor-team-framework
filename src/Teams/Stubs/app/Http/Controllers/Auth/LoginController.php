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
        $invite = Elegon::invite()->findByToken(session('invite_token'));

        return view('pages.auth.login', compact('invite'));
    }

    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, $user)
    {
        if (session('invite_token')) {
            $invite = Elegon::invite()->findByToken(session('invite_token'));

            if ($invite && $invite->isFor($user)) {
                flash()->success("You have joined {$invite->team->name}.");
                $invite->accept();
                return redirect()->route('team.show', $invite->team);
            }

            session()->forget('invite_token');

            //
        }

        //
    }
}
