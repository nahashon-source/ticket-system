<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use App\Foundation\FileMaintenanceMode;
use Illuminate\Support\Facades\Blade;
use Illuminate\Contracts\Validation\Factory as ValidationFactoryContract;
use App\Validation\CustomValidationFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register custom maintenance mode driver
        $this->app->singleton(MaintenanceMode::class, function () {
            return new FileMaintenanceMode;
        });

        // Bind the custom validation factory
        // $this->app->singleton(ValidationFactoryContract::class, function ($app) {
        //     return new CustomValidationFactory($app['translator'], $app);
        // });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Blade components
        Blade::component('alert', \App\View\Components\Alert::class);
    }
}
