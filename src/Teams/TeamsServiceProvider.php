<?php

namespace Elegon\Teams;

use Event;
use Route;
use Elegon;
use Illuminate\Auth\Events\Login;
use Elegon\Foundation\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Elegon\Teams\Listeners\JoinTeamListener;

class TeamsServiceProvider extends ServiceProvider
{
    protected $configs = [ 'teams' ];

    public function boot()
    {
        $this->publishConfigs();
        $this->loadMigrations();

        // Route model binding.
        Route::model('team', Elegon::teamModel());
        Route::model('invite', Elegon::inviteModel());

        // Event Listeners.
        Event::listen(Login::class, config('elegon.teams.join_team_listener'));
        Event::listen(Registered::class, config('elegon.teams.join_team_listener'));
    }

    public function register()
    {
        $this->mergeConfigs();
    }
}