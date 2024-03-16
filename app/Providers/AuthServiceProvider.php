<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('addcustomer', function ($user) {
            return $user->role === '1';
        });

        Gate::define('editcustomer', function ($user) {
            return $user->role === '2';
        });

        Gate::define('deletecustomer', function ($user) {
            return $user->role === '1';
        });
    }
}