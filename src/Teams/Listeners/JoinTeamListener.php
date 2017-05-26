<?php

namespace Elegon\Teams\Listeners;

use Elegon;

class JoinTeamListener
{
    /**
     * Checks if an invite token has been given during login/registration
     * and accepts it if possible. Otherwise we fail silently.
     */
    public function handle($event)
    {
        if (session('invite_token')) {
            $invite = Elegon::invite()->findByToken(session('invite_token'));

            if ($invite && $invite->isFor($event->user)) {
                $invite->accept($event->user);
                flash()->success("You have joined {$invite->team->name}.");
                session()->flash('joined_team', $invite->team->id);
                return redirect()->route('team.show', $invite->team);
            }

            session()->forget('invite_token');
        }
    }
}