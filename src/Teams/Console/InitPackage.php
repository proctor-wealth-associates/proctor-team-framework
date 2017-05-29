<?php

namespace Elegon\Teams\Console;

use Elegon\Foundation\Console\ManipulatesApplication;

class InitPackage
{
    use ManipulatesApplication;

    public $description = 'for making our users work better together.';

    public function handle()
    {
        $this->initConfigurations();
        $this->scaffoldRoutesAndControllers();
        $this->scaffoldAppFolder();
        $this->scaffoldModels();
        $this->scaffoldResources();
        $this->scaffoldPublicFolder();
    }

    protected function initConfigurations()
    {
        $this->title('Initializes configurations');
        $this->publish('Teams', 'config');
    }

    protected function scaffoldRoutesAndControllers()
    {
        $this->title('Scaffolds routes and controllers');
        $this->append('routes/web.php');
        $this->add('app/Http/Controllers/Teams');
        $this->replace('app/Http/Controllers/Auth/LoginController.php'); // CONFLICT WITH FOUNDATION
        $this->replace('app/Http/Controllers/Auth/RegisterController.php'); // CONFLICT WITH FOUNDATION
    }

    protected function scaffoldAppFolder()
    {
        $this->title('Scaffolds app folder');
        $this->add('app/Mail');
        $this->add('app/Policies/InvitePolicy.php');
        $this->add('app/Policies/TeamPolicy.php');
        $this->replace('app/Policies/UserPolicy.php'); // CONFLICT WITH FOUNDATION
        $this->replace('app/Providers/AuthServiceProvider.php'); // CONFLICT WITH FOUNDATION
    }

    protected function scaffoldModels()
    {
        $this->title('Scaffolds models');
        $this->add('database/migrations');
        $this->add('app/Team.php');
        $this->edit('app/User.php', [
            "#(namespace App;\n)#" => "\\1\nuse Elegon\\Teams\\Concerns\\CanJoinTeams;",
            "#(use Notifiable);#" => "\\1, CanJoinTeams;"
        ]);
    }

    protected function scaffoldResources()
    {
        $this->title('Scaffolds views');
        $this->add('resources/views/components');
        $this->add('resources/views/emails');
        $this->add('resources/views/layouts/app/header');
        $this->edit('resources/views/layouts/app/header.blade.php', [
            "#(@include\('layouts\.app\.header.user'\))#" 
            => "@include('layouts.app.header.team')\n                \\1"
        ]);
        $this->replace('resources/views/pages/auth/login.blade.php'); // CONFLICT WITH FOUNDATION
        $this->replace('resources/views/pages/auth/register.blade.php'); // CONFLICT WITH FOUNDATION
        $this->add('resources/views/pages/team');
    }

    protected function scaffoldPublicFolder()
    {
        $this->title('Scaffolds public folder');
        $this->add('public/images/default');
    }
}