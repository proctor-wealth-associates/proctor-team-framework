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
            if (Elegon::hasPackage($packageName)) {
                $this->initPackage($packageName);
            }
        }
    }

    protected function initPackage($packageName)
    {
        $initHandlerClass = "Elegon\\$packageName\Console\InitPackage";

        if (! class_exists($initHandlerClass)) {
            $this->error("$packageName: Package initiator not found.");
            return;
        }

        $initHandler = new $initHandlerClass($this);
        $description = $initHandler->description;

        $this->info("$packageName: $description");
        $initHandler->handle();
    }
}