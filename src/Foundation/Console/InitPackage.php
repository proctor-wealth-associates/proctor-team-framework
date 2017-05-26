<?php

namespace Elegon\Foundation\Console;

use Elegon\Foundation\Console\ManipulatesApplication;

class InitPackage
{
    use ManipulatesApplication;

    public $description = 'for the scaffolding you keep doing over and over.';

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
        $this->title('Initializes configurations');
        $this->publish('Foundation', 'config');
        $this->detail('call: php artisan storage:link');
        $this->callSilent('storage:link');
        $this->replace('config/filesystems.php');
        $this->edit('config/app.php', [ "#'APP_NAME', 'Laravel'#" => "'APP_NAME', 'Elegon'" ]);
        $this->edit('.env', [ "#APP_NAME=Laravel#" => "APP_NAME=Elegon" ]);
    }

    protected function scaffoldRoutesAndControllers()
    {
        $this->title('Scaffolds routes and controllers');
        $this->replace('routes/web.php');
        $this->replace('app/Http/Controllers');
    }

    protected function scaffoldUserModel()
    {
        $this->title('Scaffolds user model');
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
        $this->title('Scaffolds views');
        $this->replace('resources/views');

        $this->title('Scaffolds assets');
        $this->replace('resources/assets/js');
        $this->replace('resources/assets/less');
        $this->delete('resources/assets/sass');
        $this->replace('webpack.mix.js');
    }

    protected function scaffoldPublicFolder()
    {
        $this->title('Scaffolds public folder');
        $this->replace('public/js');
        $this->replace('public/css');
        $this->add('public/images');
        $this->add('public/fonts');
    }

    protected function composerDependencies()
    {
        $this->title('Add composer dependencies');
        $this->exec('composer require intervention/image ^2.3');
    }

    protected function npmDependencies()
    {
        $this->title('Add npm dependencies');
        $this->exec('npm remove bootstrap-sass --save-dev');
        $this->edit('package.json', [
            '#("scripts": {\n)#' 
            => "\\1\t\t\"postinstall\": \"node resources/assets/js/vendor/semantic-fix.js\",\n"
        ]);
        $this->exec('npm install semantic-ui-less --save-dev');
    }
}