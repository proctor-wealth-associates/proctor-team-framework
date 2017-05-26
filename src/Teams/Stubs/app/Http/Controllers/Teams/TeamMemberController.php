<?php

namespace App\Http\Controllers\Teams;

use Auth;
use App\Team;
use App\User;
use App\Http\Controllers\Controller;
use Elegon\Teams\Events\UserLeftTeam;

class TeamMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:deleteMember,team,user')->only('destroy');
    }

    /**
     * Remove the specified user from the given team.
     */
    public function destroy(Team $team, User $user)
    {
        $user->detachTeam($team);

        event(new UserLeftTeam($user, $team));

        if (Auth::user()->is($user)) {
            flash()->success("You have left {$team->name}.");
            return redirect()->route('team.index');
        }

        return redirect()->back();
    }
}
