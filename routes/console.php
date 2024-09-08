<?php

use App\Http\Controllers\EventController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('closeEvents', function () {
    $eventController = app(EventController::class);
    $eventController->closeEventInPastIfNotClosedOrDeleted();
})->purpose('Start close all events')->everyFifteenMinutes();
