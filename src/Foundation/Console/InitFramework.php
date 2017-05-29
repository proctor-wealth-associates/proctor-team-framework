<?php

namespace Elegon\Foundation\Console;

use Elegon;
use Illuminate\Console\Command;

class InitFramework extends Command
{
    protected $signature = 'elegon:init {--package=}';

    protected $description = 'Initializes and scaffolds elegon\'s framework';

    public function handle()
    {
        $packageName = $this->option('package');

        if ($packageName) {
            $this->initPackage($packageName);
            return;
        }

        $this->initAllUsedPackages();
        $this->comment("\n\u{1F984}  Craft something mind-blowing! \u{1F417}");
    }

    protected function initAllUsedPackages()
    {
        foreach (Elegon::PACKAGES as $packageName) {
            if (Elegon::hasPackage($packageName)  && $this->hasPackageHandler($packageName)) {
                $this->initPackage($packageName);
            }
        }
    }

    protected function initPackage($packageName)
    {
        if (! $this->hasPackageHandler($packageName)) {
            return $this->error("$packageName: Package initiator not found.");
        }

        $initHandlerClass = "Elegon\\$packageName\Console\InitPackage";
        $initHandler = new $initHandlerClass($this);
        $description = $initHandler->description;

        $this->info("$packageName: $description");
        $initHandler->handle();
    }

    protected function hasPackageHandler($packageName)
    {
        $packageHandlerClass = "Elegon\\$packageName\Console\InitPackage";

        return class_exists($packageHandlerClass);
    }
}