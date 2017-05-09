<?php

namespace Elegon\Foundation\Console;

use Illuminate\Console\Command;

class PublishConfigs extends Command
{
    protected $signature = 'elegon:config';

    protected $description = 'Publishes elegon\'s config files';

    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'elegon_config'
        ]);
    }
}