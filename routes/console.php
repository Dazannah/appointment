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

Artisan::command('holidays', function () {
    $apiKey = env('SZUNETNAPOK_API');
    $year = '2024';
    $ssl = env('APP_ENV', 'production') == 'local' ? false : true;

    $client = new Client([
        'base_uri' => "https://szunetnapok.hu",
        'verify' => $ssl,
    ]);


    $response = $client->request('GET', "/api/$apiKey/$year");

    if ($response->getStatusCode() == 200)
        print_r(json_decode($response->getBody()->getContents(), true)['days']);
    /*print_r(json_decode($response->getBody()->getContents(), true)['response']
             Error 
        );*/
    else
        echo "Unsuccessfull request";
});
