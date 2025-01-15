<?php

namespace App\Providers;

use App\Services\GeneroServices;
use Illuminate\Support\ServiceProvider;

class GeneroServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(GeneroServices::class,function ($app){
                return new GeneroServices;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
