<?php

namespace App\Http\Controllers\Auth;

use Elegon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $invite = Elegon::invite()->findByToken(session('invite_token'));

        return view('pages.auth.login', compact('invite'));
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
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
        }
    }
}
