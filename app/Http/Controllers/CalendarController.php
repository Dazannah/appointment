<?php

namespace App\Http\Controllers;

use DateTimeZone;
use App\Models\Event;
use App\DateInterface;
use App\EventInterface;
use App\Models\WorkTypes;
use Illuminate\Http\Request;
use App\Services\DateService;
use App\Services\EventService;
use Illuminate\Support\Facades\Response;

class CalendarController extends Controller {
    private DateInterface $dateService;
    private EventInterface $eventService;

    public function __construct(DateInterface $dateService, EventInterface $eventService) {
        $this->dateService = $dateService;
        $this->eventService = $eventService;
    }

    public function getCreateEvent(Request $req) {
        return view('create-event');
    }

    public function show(Request $req) {
        return view('calendar', ['pageTitle' => 'Calendar']);
    }

    public function getEvents(Request $req) {
        $validatedData = $req->validate([
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $events = $this->eventService->getWeeklyEvents($validatedData['start'], $validatedData['end']);
        $this->eventService->AddGreenBackgroundToOwnEvent($events, auth()->id());

        return response()->json($events);
    }

    public function getAvailableWorkTypes(Request $req) {
        $validatedData = $req->validate([
            'startDate' => 'required|date',
        ]);

        $result = $this->eventService->getAvailableWorkTypes($validatedData['startDate']);

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

        $isStartInTheFuture = $this->dateService->IsStartInTheFuture($validated['start']);

        if (!$isStartInTheFuture) {
            return back()->with('error', "Can't make appointment for the past.");
        }

        $this->eventService->createEvent($validated, auth()->id());

        return redirect('/dashboard')->with('success', 'Appointment successfully saved.');
    }
}
