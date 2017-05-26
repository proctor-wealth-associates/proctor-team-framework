<?php

namespace Elegon\Foundation;

use Schema;
use Elegon\Foundation\Elegon;
use Elegon\Foundation\Console\Publish;
use Elegon\Foundation\ServiceProvider;
use Elegon\Foundation\Flash\FlashNotifier;
use Elegon\Foundation\Console\InitFramework;

class FoundationServiceProvider extends ServiceProvider
{
    protected $configs = [ 'foundation' ];

    public function boot()
    {
        Schema::defaultStringLength(255);

        $this->bootElegon();

        $this->bootFlash();

        $this->publishConfigs();

        $this->commandsInConsole([ 
            Publish::class, 
            InitFramework::class 
        ]);
    }

    public function register()
    {
        $this->mergeConfigs();

        $this->app->singleton('flash', function () {
            return $this->app->make(FlashNotifier::class);
        });
    }

    protected function bootElegon()
    {
        Elegon::useUserModel(config('auth.providers.users.model', 'App\User'));
        Elegon::useInviteModel(config('elegon.teams.invite_model'));
        Elegon::useTeamModel(config('elegon.teams.team_model'));

        if (! class_exists('Elegon')) {
            class_alias('Elegon\Foundation\Elegon', 'Elegon');
        }
    }

    protected function bootFlash()
    {
        $this->loadViewsFrom(__DIR__ . '/Flash/views', 'flash');
        $this->publishes([
            __DIR__ . '/Flash/views' => base_path('resources/views/vendor/flash')
        ], 'elegon_flash');
    }
}
