<?php

namespace Elegon\Foundation;

use ReflectionClass;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    protected $configs = [];

    protected function publishConfigs()
    {
        $configPaths = collect($this->configs)->mapWithKeys(function($config) {
            return [ "{$this->getDir()}/Config/$config.php" => config_path("elegon/$config.php") ];
        })->toArray();

        $this->publishes($configPaths, 'elegon_config');
    }

    protected function mergeConfigs()
    {
        collect($this->configs)->each(function($config) {
            $this->mergeConfigFrom("{$this->getDir()}/Config/$config.php", "elegon.$config");
        });
    }

    protected function getDir()
    {
        $classInstanciated = new ReflectionClass(static::class);

        return dirname($classInstanciated->getFileName());
    }

    protected function commandsInConsole($commands)
    {
        if ($this->app->runningInConsole()) {
            $this->commands($commands);
        }
    }
}
