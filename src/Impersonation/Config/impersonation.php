<?php

return [
    
    /**
     * The policy defines which users are allowed to impersonate other users.
     * You can select `dev` for authorizing only developers to impersonate 
     * or `role` to authorize a role withing the Elegon\Roles package.
     */
    'policy' => 'dev',
    'role' => null,

    /**
     * These define where to redirect the user when impersonation 
     * begins and finishes.
     */
    'redirect_begins' => '/home',
    'redirect_finished' => '/user/{user}',
    
];