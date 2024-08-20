<?php

namespace App\Http\Controllers;

use DateTimeZone;
use App\Models\Event;
use App\Models\WorkTypes;
use Illuminate\Http\Request;
use App\Models\TimeCalculator;
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

        $events = Event::where([['start', '>=', $start], ['end', '<=', $end], ['status_id', '!=', '3']])->get();

        foreach ($events as $event) {
            if ($event->user_id === auth()->id()) {
                $event->backgroundColor = "green";
                $event->url = "/event/$event->id";
            } else {
                $event->title = "";
            }
        }

        return response()->json($events);
    }

    public function getAvailableWorkTypes(Request $req) {
        $validatedData = $req->validate([
            'startDate' => 'required|date',
        ]);

        $event = Event::where([['start', '>=', $validatedData['startDate']], ['status_id', '!=', '3']])->orderBy('start', 'asc')->first();

        if ($event) {
            $startDate = date_create($validatedData['startDate']);
            $nextEventStart = date_create($event['start']);
            $dateDiff = date_diff($startDate, $nextEventStart);

            $availableMins = TimeCalculator::GetMinutsFromDateDiff($dateDiff);

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
            'workId' => 'required|numeric',
            'note' => 'min:0|max:255'
        ]);


        $validated['start'] = $this->formateDate($validated['start']);
        $start = str_replace(" ", "T", $validated['start']);
        $validated['end'] = $this->formateDate($validated['end']);
        $end = str_replace(" ", "T", $validated['end']);

        $startDate = date_create($validated['start']);
        $now = date_create('now', new DateTimeZone('CEST'));
        $isStartInTheFuture = TimeCalculator::IsStartInTheFuture($now, $startDate);

        if (!$isStartInTheFuture) {
            return back()->with('error', "Can't make appointment for the past.");
        }

        $work = WorkTypes::where('id', '=', $validated['workId'])->first();

        $event = [
            'user_id' => auth()->id(),
            'title' => $work['name'],
            'start' => $start,
            'end' => $end,
            'work_type_id' => $work['id'],
            'note' => $validated['note'],
        ];

        Event::create($event);

        return redirect('/dashboard')->with('success', 'Foglalás sikeresen mentve');
    }

    private function formateDate($dateTime) {
        $result = explode('T', $dateTime)[0] . ' ' . explode('T', $dateTime)[1];

        return $result;
    }
}
