<?php

namespace App\Http\Controllers\Teams;

use Auth;
use Mail;
use Elegon;
use App\Team;
use App\Mail\TeamInvite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InviteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('accept', 'ignore');
        $this->middleware('can:sendInvite,team')->only('store');
        $this->authorizePolicy(Elegon::inviteModel());
    }

    /**
     * Invite a given user to join the team by email.
     */
    public function store(Request $request, Team $team)
    {
        $this->validate($request, [ 'email' => 'required|email' ]);

        if ($team->hasPendingInvite($request->email)) {
            return redirect()->back()->withErrors([
                'email' => 'The email address is already invited to the team.'
            ]);
        }

        $invite = $team->invite($request->email);

        if (! $invite) {
            return redirect()->back()->withErrors([
                'email' => 'The invite could not be created. Please try again later.'
            ]);
        }

        Mail::send(new TeamInvite($invite));
        
        return redirect()->back();
    }

    /**
     * Resend an invitation mail.
     */
    public function resend($invite)
    {
        Mail::send(new TeamInvite($invite));

        flash()->success('Invitation has been resent.');

        return redirect()->route('team.show', $invite->team);
    }

    /**
     * Accept the given invite.
     */
    public function accept($token)
    {
        if (! ($invite = Elegon::invite()->findByToken($token))) {
            abort(404);
        }

        if (Auth::guest() || ! $invite->isFor(Auth::user())) {
            Auth::logout();
            session([ 'invite_token' => $token ]);
            return redirect()->route('register');
        }

        $invite->accept();
        flash()->success("You have joined {$invite->team->name}.");
        return redirect()->route('team.show', $invite->team);
    }

    /**
     * Ignore the invite token session variable given via email.
     */
    public function ignore()
    {
        session()->forget('invite_token');

        return redirect()->back();
    }

    /**
     * Cancel an invite that has not yet been accepted.
     */
    public function destroy($invite)
    {
        $invite->cancel();

        return redirect()->back();
    }
}
