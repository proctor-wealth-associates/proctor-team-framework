<?php

namespace Elegon\Foundation;

use Illuminate\Support\ServiceProvider;
use Elegon\Foundation\Commands\PublishConfigs;

class FoundationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Publishes the config files.
        $this->publishes([
            __DIR__.'/stubs/config/elegon.php' => config_path('elegon.php')
        ], 'config');

        // Initializes commands.
        if ($this->app->runningInConsole()) {
            $this->commands([
                PublishConfigs::class,
            ]);
        }
    }
}
