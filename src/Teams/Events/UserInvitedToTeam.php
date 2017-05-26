<?php

namespace Elegon\Teams\Events;

use Illuminate\Queue\SerializesModels;

class UserInvitedToTeam
{
    use SerializesModels;

    public $invite;

    public function __construct($invite)
    {
        $this->invite = $invite;
    }
}