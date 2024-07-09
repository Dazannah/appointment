<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CalendarController extends Controller {
    public function show(Request $req) {
        return view('calendar');
    }

    public function getEvents(Request $req) {
        // example get request /myfeed.php?start=2013-12-01T00:00:00-05:00&end=2014-01-12T00:00:00-05:00
        $validatedData = $req->validate([
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $start = $validatedData['start'];
        $end = $validatedData['end'];

        $events = Event::where([['start', '>=', $start], ['end', '<=', $end]])->get();

        return response()->json($events);
    }

    public function createEvent(Request $req) {
        $event = [
            'user_id' => auth()->id(),
            'title' => 'title1',
            'start' => now(),
            'end' => now()
        ];

        //Event::create($event);

        // $exampleEvents = [
        //     [
        //         'id' => 'id2',
        //         'title' => 'title2',
        //         'start' => '2024-07-10T09:00:00',
        //         'end' => '2024-07-10T10:00:00'
        //     ],
        //     [
        //         'id' => 'id3',
        //         'title' => 'title3',
        //         'start' => '2024-07-11T09:00:00',
        //         'end' => '2024-07-11T10:00:00'
        //     ],
        // ];
    }
}
