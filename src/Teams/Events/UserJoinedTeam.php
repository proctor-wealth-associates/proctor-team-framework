<?php

namespace Elegon\Teams\Events;

use Illuminate\Queue\SerializesModels;

class UserJoinedTeam
{
    use SerializesModels;

    public $user;
    public $team;

    public function __construct($user, $team)
    {
        $this->user = $user;
        $this->team = $team;
    }
}
