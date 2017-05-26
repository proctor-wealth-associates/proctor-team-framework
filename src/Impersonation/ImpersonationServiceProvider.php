<?php

namespace Elegon\Impersonation;

use Elegon\Foundation\ServiceProvider;

class ImpersonationServiceProvider extends ServiceProvider
{
    protected $configs = [ 'impersonation' ];

    public function boot()
    {
        $this->publishConfigs();
        $this->loadRoutes();
    }

    public function register()
    {
        $this->mergeConfigs();
    }
}