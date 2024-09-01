<?php

namespace App\Providers;

use App\Interfaces\IDate;
use App\Interfaces\IEvent;
use App\Services\DateService;
use App\Services\EventService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(IDate::class, DateService::class);
        $this->app->bind(IEvent::class, EventService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
