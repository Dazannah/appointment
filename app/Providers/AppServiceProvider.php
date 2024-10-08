<?php

namespace App\Providers;

use App\Interfaces\IDate;
use App\Interfaces\IEvent;
use App\Services\DateService;
use App\Services\UserService;
use App\Interfaces\IClosedDay;
use App\Services\EventService;
use App\Services\PriceService;
use App\Interfaces\ISiteConfig;
use App\Interfaces\IUserService;
use App\Interfaces\IPriceService;
use App\Services\WorktypeService;
use App\Services\ClosedDayService;
use App\Services\SiteConfigService;
use App\Interfaces\IWorktypeService;
use App\Interfaces\IDataSerialisation;
use App\Interfaces\IRequest;
use Illuminate\Support\ServiceProvider;
use App\Services\DataSerialisationService;
use App\Services\RequestService;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        $this->app->bind(IDate::class, DateService::class);
        $this->app->bind(IEvent::class, EventService::class);
        $this->app->bind(IDataSerialisation::class, DataSerialisationService::class);
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IWorktypeService::class, WorktypeService::class);
        $this->app->bind(IPriceService::class, PriceService::class);
        $this->app->bind(ISiteConfig::class, SiteConfigService::class);
        $this->app->bind(IClosedDay::class, ClosedDayService::class);
        $this->app->bind(IRequest::class, RequestService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //
    }
}
