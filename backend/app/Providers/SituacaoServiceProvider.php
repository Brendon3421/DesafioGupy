<?php

namespace App\Providers;

use App\Services\SituacaoServices;
use Illuminate\Support\ServiceProvider;

class SituacaoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(SituacaoServices::class, function($app){
                return new SituacaoServices();
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
