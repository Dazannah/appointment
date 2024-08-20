<?php

namespace App\Http\Controllers;

use DateTimeZone;
use App\Models\Event;
use App\Models\TimeCalculator;
use DateTime;
use Illuminate\Http\Request;

class EventController extends Controller {
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
        return view('manage-event', ['event' => $event]);
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
            return $this->destroy($event);
        }

        if ($validatedData['note'] != $event->note) {
            $event->note = $validatedData['note'];
            $event->save();
        };

        return back()->with('success', 'Successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event) {

        $startDate = date_create($event['start']);
        $now = date_create('now', new DateTimeZone('CEST'));
        $dateDiff = date_diff($startDate, $now);

        $availableMins = TimeCalculator::GetMinutsFromDateDiff($dateDiff);
        $isMoreThanADay = TimeCalculator::IsMoreThanADay($availableMins);

        if (!$isMoreThanADay) {
            //kötbér tábla hozzá adás, a táblához státus id mező
        }

        $event->status_id = 3;
        $event->save();

        return redirect('/dashboard')->with('success', 'Successfully deleted');
    }
}
