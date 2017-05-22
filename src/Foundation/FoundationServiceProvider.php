<?php

namespace Elegon\Foundation;

use Elegon\Foundation\Elegon;
use Elegon\Foundation\ServiceProvider;
use Elegon\Foundation\Console\PublishConfigs;
use Elegon\Foundation\Console\InitializeFramework;

class FoundationServiceProvider extends ServiceProvider
{
    protected $configs = [ 'foundation' ];

    public function boot()
    {
        // Initializes elegon static helper.
        Elegon::useUserModel(config('auth.providers.users.model', 'App\User'));
        Elegon::useTeamModel(config('elegon.teams.model', 'App\Team'));

        $this->publishConfigs();

        // Initializes commands.
        $this->commandsInConsole([ 
            PublishConfigs::class, 
            InitializeFramework::class 
        ]);
    }

    public function register()
    {
        $this->mergeConfigs();
    }
}
