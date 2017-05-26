<?php

namespace Elegon\Foundation\Console;

use Elegon\Foundation\Elegon;
use Illuminate\Console\Command;

class Publish extends Command
{
    protected $signature = 'elegon:publish {--tag=} {--package=}';

    protected $description = 'Publishes the content of elegon\'s packages';

    public function handle()
    {
        if ($this->noOptions()) {
            return $this->publishAllPackages();
        }

        $this->call('vendor:publish', $this->getPublishOptions());
    }

    protected function publishAllPackages()
    {
        if (! $this->confirm('Do you really want to publish all used packages?')) {
            return;
        }

        foreach (Elegon::PACKAGES as $packageName) {
            if (Elegon::hasPackage($packageName)) {
                $this->line("$packageName:");
                $this->call('vendor:publish', [
                    '--provider' => $this->getProviderOfPackage($packageName)
                ]);
            }
        }
    }

    protected function getPublishOptions()
    {
        $options = [];
        $packageName = $this->option('package');
        $tag = $this->option('tag');

        if ($packageName) {
            $options[ '--provider'] = $this->getProviderOfPackage($packageName);
        }

        if ($tag) {
            $options[ '--tag'] = "elegon_$packageName";
        }

        return $options;
    }

    protected function getProviderOfPackage($packageName)
    {
        return "Elegon\\$packageName\\${packageName}ServiceProvider";
    }

    protected function noOptions()
    {
        return ! $this->option('package') && ! $this->option('tag');
    }
}