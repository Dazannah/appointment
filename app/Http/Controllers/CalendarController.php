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
        //$workTypes = WorkTypes::with("price")->get();

        return view('calendar'/*, ["workTypes" => $workTypes]*/);
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

    public function getAvailableWorkTypes(Request $req) {
        $validatedData = $req->validate([
            'startDate' => 'required|date',
        ]);

        $event = Event::where([['start', '>=', $validatedData['startDate']]])->orderBy('start', 'asc')->first();

        if ($event) {
            $startDate = date_create($validatedData['startDate']);
            $nextEventStart = date_create($event['start']);
            $dateDiff = date_diff($startDate, $nextEventStart);

            $availableMins = 0;
            $availableMins += $dateDiff->y * 24 * 60 * 30 * 365;
            $availableMins += $dateDiff->m * 24 * 60 * 30;
            $availableMins += $dateDiff->d * 24 * 60;
            $availableMins += $dateDiff->h * 60;
            $availableMins += $dateDiff->i;

            $result =  WorkTypes::where([['duration', '<=', $availableMins]])->with("price")->get();
        } else {
            $result = WorkTypes::with("price")->get();
        }

        return response()->json($result);
    }

    public function createEvent(Request $req) {
        $validated = $req->validate([
            'title' => 'required',
            'start' => 'required|date',
            'end' => 'required|date',
            'workId' => 'required|numeric'
        ]);


        $validated['start'] = $this->formateDate($validated['start']);
        $start = str_replace(" ", "T", $validated['start']);
        $validated['end'] = $this->formateDate($validated['end']);
        $end = str_replace(" ", "T", $validated['end']);

        $work = WorkTypes::where('id', '=', $validated['workId'])->first();

        $event = [
            'user_id' => auth()->id(),
            'title' => $work['name'],
            'start' => $start,
            'end' => $end,
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
