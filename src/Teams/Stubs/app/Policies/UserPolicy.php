<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the given user.
     */
    public function view(User $user, User $userProfile)
    {
        return $user->is($userProfile)
            || $user->hasTeamInCommonWith($userProfile);
    }

    /**
     * Determine whether the user can update or delete the given user.
     */
    public function manage(User $user, User $userProfile)
    {
        return $user->is($userProfile);
    }
}
