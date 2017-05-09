<?php

namespace Elegon\Foundation\Commands;

use Illuminate\Console\Command;

class PublishConfigs extends Command
{
    protected $signature = 'elegon:config';

    protected $description = 'Publishes elegon\'s config files';

    public function handle()
    {
        $this->callSilent('vendor:publish', [
            '--tag' => 'config',
            '--provider' => 'Elegon\Foundation\FoundationServiceProvider'
        ]);
    }
}