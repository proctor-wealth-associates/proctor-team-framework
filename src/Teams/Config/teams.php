<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you decide to move your Team model somewhere else or use your own 
    | Invite model, here is the place to tell the package where they are.
    | You can extend these classes if you want to inherit their ability.
    */
   
    'team_model' => App\Team::class,
    'invite_model' => Elegon\Teams\Invite::class,

    /*
    |--------------------------------------------------------------------------
    | Tables
    |--------------------------------------------------------------------------
    |
    | Here, you can customize the names of the pivot tables to use. 
    | For customzing the User and Team table you can simply 
    | override the `$table` property on the model.
    */
   
    'invite_table' => 'team_invites',
    'team_user_table' => 'team_user',

    /*
    |--------------------------------------------------------------------------
    | Listeners
    |--------------------------------------------------------------------------
    |
    | Everytime a user logs in or registered we fire a listener that checks if
    | the user followed an invite and should therefore be added to a team.
    | If you wish to use your own listener, write down its class here.
    */
   
    'join_team_listener' => Elegon\Teams\Listeners\JoinTeamListener::class,

];