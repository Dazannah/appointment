<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\WorkTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CalendarController extends Controller {
    public function getCreateEvent(Request $req) {
        return view('create-event');
    }

    public function show(Request $req) {
        $workTypes = WorkTypes::with("price")->get();

        return view('calendar', ["workTypes" => $workTypes]);
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
        $validated = $req->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'workId' => 'required|numeric'
        ]);


        $validated['start'] = $this->formateDate($validated['start']);
        $validated['end'] = $this->formateDate($validated['end']);

        $work = WorkTypes::where('id', '=', $validated['workId'])->first();

        $event = [
            'user_id' => auth()->id(),
            'title' => $work['name'],
            'start' => $validated['start'],
            'end' => $validated['end'],
            'work_type_id' => $work['id']
        ];

        Event::create($event);

        return redirect('/dashboard')->with('success', 'Foglalás sikeresen mentve');
    }

    private function formateDate($dateTime) {
        $result = explode('T', $dateTime)[0] . ' ' . explode('T', $dateTime)[1];

        return $result;
    }
}
