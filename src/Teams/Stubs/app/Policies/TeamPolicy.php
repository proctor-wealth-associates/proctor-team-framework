<?php

namespace App\Policies;

use App\Team;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the given team.
     */
    public function view(User $user, Team $team)
    {
        return $team->hasUser($user);
    }

    /**
     * Determine whether the user can create a new team.
     * E.g. You can check for team limits here.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update or delete the given team.
     */
    public function manage(User $user, Team $team)
    {
        return $user->isOwnerOfTeam($team);
    }

    /**
     * Determine whether the user can switch to the given team.
     */
    public function switch(User $user, Team $team)
    {
        return $team->hasUser($user);
    }

    /**
     * Determine whether the user can invite in the given team.
     */
    public function sendInvite(User $user, Team $team)
    {
        return $team->hasUser($user);
    }

    /**
     * Determine whether the user can kick out another member of the team.
     */
    public function deleteMember(User $user, Team $team, User $userToKickOut)
    {
        if ($user->is($userToKickOut)) {
            return ! $userToKickOut->isOwnerOfTeam($team);
        }

        return $this->manage($user, $team);
    }
}
