<?php

namespace App\Providers;

use Elegon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }

    /**
     * Register all gates and policies.
     */
    public function registerPolicies()
    {
        Gate::policy(Elegon::userModel(), 'App\Policies\UserPolicy');
        Gate::policy(Elegon::teamModel(), 'App\Policies\TeamPolicy');
        Gate::policy(Elegon::inviteModel(), 'App\Policies\InvitePolicy');

        //
    }
}
