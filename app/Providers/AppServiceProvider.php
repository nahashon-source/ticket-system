<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\MaintenanceMode;
use App\Foundation\FileMaintenanceMode;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MaintenanceMode::class, function () {
            return new FileMaintenanceMode;
        });
    }

    public function boot(): void
    {
        //
    }
}
