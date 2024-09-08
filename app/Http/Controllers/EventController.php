<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Interfaces\IEvent;
use Illuminate\Http\Request;

class EventController extends Controller {

    protected IEvent $eventService;

    public function __construct(IEvent $eventService) {
        $this->eventService = $eventService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event) {
        if ($event->status->id === 3 || $event->status->id === 4) {
            return back()->with('error', "Can't edit closed event.");
        }

        return view('manage-event', ['event' => $event, 'pageTitle' => 'Manage reservation']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event) {
        $validatedData = $request->validate([
            'note' => 'min:0|max:255',
            'delete' => ''
        ]);

        if (isset($validatedData['delete'])) {
            return $this->eventService->setStatusDeleted($event);
        }

        $this->eventService->updateEvent($event, $validatedData);

        return back()->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event) {
    }

    public function closeEventInPastIfNotClosedOrDeleted() {
        $eventService = app(IEvent::class);
        $events = $eventService->getAllOpenEvent();

        $eventService->closeGivenEvents($events);
    }
}
