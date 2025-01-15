<?php

namespace App\Providers;

use App\Models\User;
use App\Services\LoginServices;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class LoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(LoginServices::class, function ($app) {
            return  new LoginServices();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, $ability) {
            if ($user->allAbilities()->contains($ability)) {
                return true;
            }
        });
    }
}
