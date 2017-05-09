<?php

namespace Elegon\Impersonation;

use Elegon\Foundation\ServiceProvider;

class ImpersonationServiceProvider extends ServiceProvider
{
    protected $configs = [ 'impersonation' ];

    public function boot()
    {
        $this->publishConfigs();
        $this->loadRoutesFrom(__DIR__.'/routes.php');
    }

    public function register()
    {
        $this->mergeConfigs();
    }
}