<?php

namespace App\Providers;

use App\DateInterface;
use App\EventInterface;
use App\Services\DateService;
use App\Services\EventService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(DateInterface::class, DateService::class);
        $this->app->bind(EventInterface::class, EventService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
