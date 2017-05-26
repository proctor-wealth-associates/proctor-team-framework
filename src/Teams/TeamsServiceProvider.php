<?php

namespace Elegon\Teams;

use Route;
use Elegon\Foundation\Elegon;
use Elegon\Foundation\ServiceProvider;

class TeamsServiceProvider extends ServiceProvider
{
    protected $configs = [ 'teams' ];

    public function boot()
    {
        $this->publishConfigs();
        $this->loadMigrations();

        // Route model binding
        Route::model('team', Elegon::teamModel());
        Route::model('invite', Elegon::inviteModel());
    }

    public function register()
    {
        $this->mergeConfigs();
    }
}