<?php

return [

    'team_model' => App\Team::class,
    'invite_model' => Elegon\Teams\Invite::class,

    'invite_table' => 'team_invites',
    'team_user_table' => 'team_user',
    'user_foreign_key' => 'id',

];