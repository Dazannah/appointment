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
    public function edit(Request $request, Event $event) {
        if ($event->status->id === 3 || $event->status->id === 4) {
            if ($request->wantsJson())
                return response()->json(['error' => "Can't edit closed event."]);
            else
                return back()->with('error', "Can't edit closed event.");
        }

        if ($request->wantsJson())
            return response()->json(['event' => $event, 'pageTitle' => 'Manage reservation']);
        else
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

        $this->eventService->updateEvent($event, $validatedData);
        if ($request->wantsJson())
            return response()->json(['success' => 'Successfully updated']);
        else
            return back()->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Event $event) {
        $validatedData = $request->validate([
            'delete' => ''
        ]);

        if (isset($validatedData['delete'])) {
            $response =  $this->eventService->setStatusDeleted($event);

            if (isset($response['error'])) {
                if ($request->wantsJson())
                    return response()->json($response);
                else
                    return back()->with('error', $response['error']);
            }

            if ($request->wantsJson())
                return response()->json($response);
            else
                return back()->with('error', $response['success']);
        } else {
            if ($request->wantsJson())
                return response()->json(['message' => 'Nothing happend']);
            else
                return back()->with('error', 'Nothing happend');
        }
    }

    public function closeEventInPastIfNotClosedOrDeleted() {
        $eventService = app(IEvent::class);
        $events = $eventService->getAllOpenEndedEvents();

        $eventService->closeGivenEvents($events);
    }
}
