<?php

namespace Elegon\Foundation;

use Route;
use ReflectionClass;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    protected $configs = [];

    /**
     * Publish all configuration files from the $configs property.
     */
    protected function publishConfigs()
    {
        $configPaths = collect($this->configs)->mapWithKeys(function($config) {
            return [ $this->getDir("Config/$config.php") => config_path("elegon/$config.php") ];
        })->toArray();

        $this->publishes($configPaths, 'elegon_config');
    }

    /**
     * Merge all configuration files from the $configs property.
     */
    protected function mergeConfigs()
    {
        collect($this->configs)->each(function($config) {
            $this->mergeConfigFrom($this->getDir("Config/$config.php"), "elegon.$config");
        });
    }

    /**
     * Load and publish all migrations from the 'Migrations/' folder.
     */
    protected function loadMigrations()
    {
        $this->loadMigrationsFrom($this->getDir('Migrations'));
        $this->publishes([
            $this->getDir('Migrations') => database_path('migrations')
        ], 'elegon_migration');
    }

    /**
     * Load and publish all routes from the 'Routes/' folder.
     */
    protected function loadRoutes($path = 'routes.php')
    {
        if (Elegon::routesDisabledFor($this->getPackageName())) {
            return;
        }

        if ($this->app->routesAreCached()) {
            return;
        }

        Route::group(
            [
                'namespace' => $this->getNamespace('Controllers'),
                'prefix' => Elegon::routePrefix()
            ],
            function () use ($path) { require $this->getDir($path); }
        );
    }

    /**
     * Boot commands if the application is running in the console.
     */
    protected function commandsInConsole(array $commands)
    {
        if ($this->app->runningInConsole()) {
            $this->commands($commands);
        }
    }

    /**
     * Helper: Get the root directory of the instanciated sub-class.
     */
    protected function getDir($path = '')
    {
        $classInstanciated = new ReflectionClass(static::class);
        $path = $path === '' ? '' : "/$path"; 

        return dirname($classInstanciated->getFileName()) . $path;
    }


    /**
     * Helper: Get the root namespace of the package.
     * E.g. "Elegon\Foundation" or "Elegon\Teams"
     */
    protected function getNamespace($path = '')
    {
        $classInstanciated = new ReflectionClass(static::class);
        $path = $path === '' ? '' : "\\$path"; 

        return $classInstanciated->getNamespaceName() . $path;
    }

    /**
     * Helper: Get the short name of the current package.
     * E.g. "Foundation" or "Teams".
     */
    protected function getPackageName()
    {
        $classInstanciated = new ReflectionClass(static::class);
        $offset = - strlen("ServiceProvider");

        return substr($classInstanciated->getShortName(), 0, $offset);
    }
}
