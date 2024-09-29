<?php

use GuzzleHttp\Client;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\EventController;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $eventController = app(EventController::class);
    $eventController->closeEventInPastIfNotClosedOrDeleted();
})->everyFifteenMinutes();

Schedule::command('sanctum:prune-expired --hours=24')->daily();
