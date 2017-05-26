<?php

namespace App\Policies;

use App\Team;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can cancel the given invite.
     */
    public function delete(User $user, $invite)
    {
        $isInviter = $invite->inviter && $user->is($invite->inviter);

        return $user->isOwnerOfTeam($invite->team) || $isInviter;
    }
}
