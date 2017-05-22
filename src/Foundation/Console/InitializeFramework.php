<?php

namespace Elegon\Foundation\Console;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;

class InitializeFramework extends Command
{
    protected $signature = 'elegon:init';

    protected $description = 'Initializes and scaffolds elegon\'s framework';

    public function handle()
    {
        $this->initConfigurations();
        $this->scaffoldRoutesAndControllers();
        $this->scaffoldUserModel();
        $this->scaffoldResources();
        $this->scaffoldPublicFolder();
        $this->composerDependencies();
        $this->npmDependencies();
    }

    protected function initConfigurations()
    {
        $this->info('Initializes configurations');
        $this->detail('call: php artisan elegon:config');
        $this->callSilent('elegon:config');
        $this->detail('call: php artisan storage:link');
        $this->callSilent('storage:link');
        $this->replace('config/filesystems.php');
    }

    protected function scaffoldRoutesAndControllers()
    {
        $this->info('Scaffolds routes and controllers');
        $this->replace('routes/web.php');
        $this->replace('app/Http/Controllers');
    }

    protected function scaffoldUserModel()
    {
        $this->info('Scaffolds user model');
        $this->replace('app/User.php');
        $this->replace('database/migrations');
        $this->add('app/Jobs');
        $this->add('app/Policies');
        $this->edit('app/Providers/AuthServiceProvider.php', [
            "#'App\\\\Model' => 'App\\\\Policies\\\\ModelPolicy'#" 
            => "'App\User' => 'App\Policies\UserPolicy'"
        ]);
    }

    protected function scaffoldResources()
    {
        $this->info('Scaffolds views');
        $this->replace('resources/views');

        $this->info('Scaffolds assets');
        $this->replace('resources/assets/js');
        $this->replace('resources/assets/less');
        $this->delete('resources/assets/sass');
        $this->replace('webpack.mix.js');
    }

    protected function scaffoldPublicFolder()
    {
        $this->info('Scaffolds public folder');
        $this->replace('public/js');
        $this->replace('public/css');
        $this->add('public/images');
        $this->add('public/fonts');
    }

    protected function composerDependencies()
    {
        $this->info('Add composer dependencies');
        $this->exec('composer require intervention/image ^2.3');
    }

    protected function npmDependencies()
    {
        $this->info('Add npm dependencies');
        $this->exec('npm remove bootstrap-sass --save-dev');
        $this->edit('package.json', [
            '#("scripts": {\n)#' 
            => "\\1\t\t\"postinstall\": \"node resources/assets/js/vendor/semantic-fix.js\",\n"
        ]);
        $this->exec('npm install semantic-ui-less --save-dev');
    }

    protected function detail($text)
    {
        parent::line($text, null, OutputInterface::VERBOSITY_VERBOSE);
    }

    protected function replace($path, $silent = false)
    {
        if (! $silent) $this->detail("replace: $path");

        $this->delete($path, true);
        $this->add($path, true);
    }

    protected function add($path, $silent = false)
    {
        if (! $silent) $this->detail("add: $path");

        copy_folder(__DIR__ . '/../Stubs/' . $path, base_path($path));
    }

    protected function delete($path, $silent = false)
    {
        if (! $silent) $this->detail("delete: $path");

        if (is_file(base_path($path))) {
            unlink(base_path($path));
        } else {
            delete_folder(base_path($path));
        }
    }

    protected function edit($path, $changes, $silent = false)
    {
        if (! $silent) $this->detail("edit: $path");

        $file = file_get_contents(base_path($path));

        foreach ($changes as $pattern => $replacement) {
            $file = preg_replace($pattern, $replacement, $file);
        }

        file_put_contents(base_path($path), $file);
    }

    protected function exec($script, $silent = false)
    {
        if (! $silent) $this->detail("call: $script");

        $process = new Process($script);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        if (! $silent) $this->detail($process->getOutput());
    }
}