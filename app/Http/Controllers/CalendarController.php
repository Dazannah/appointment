<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Interfaces\IDate;
use App\Models\WorkTypes;
use App\Interfaces\IEvent;
use Illuminate\Http\Request;
use App\Interfaces\IClosedDay;
use App\Interfaces\ISiteConfig;

use function Pest\Laravel\json;
use App\Interfaces\IWorktypeService;

use function Pest\Laravel\json;
use App\Interfaces\IWorktypeService;

class CalendarController extends Controller {
    private IDate $dateService;
    private IEvent $eventService;
    private ISiteConfig $siteConfigService;
    private IWorktypeService $worktypeService;
    private IClosedDay $closedDayService;


    public function __construct(IDate $dateService, IEvent $eventService, ISiteConfig $siteConfigService, IWorktypeService $worktypeService, IClosedDay $closedDayService) {
        $this->dateService = $dateService;
        $this->eventService = $eventService;
        $this->siteConfigService = $siteConfigService;
        $this->worktypeService = $worktypeService;
        $this->closedDayService = $closedDayService;
    }

    public function getNextAvailableEventTime(WorkTypes $worktype) {
        $result = $this->eventService->getNextAvailableEventTime($worktype, date('Y-m-d') /*'2024-09-11'*/);

        return json_encode($result);
    }

    public function getCreateEvent(Request $req) {
        return view('create-event');
    }

    public function show(Request $req) {
        $config = $this->siteConfigService->getConfig();
        $calendartime = $config['calendarTimes'];

        return view('calendar', ['pageTitle' => 'Calendar', 'calendarTimes' => $calendartime]);
    }

    public function getEvents(Request $req) {
        $validatedData = $req->validate([
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        $events = $this->eventService->getWeeklyEvents($validatedData['start'], $validatedData['end']);
        $this->eventService->AddGreenBackgroundToOwnEvent($events, auth()->id());

        $closedDays = $this->closedDayService->getWeeklyClosedDays($validatedData['start'], $validatedData['end']);
        $response = $this->closedDayService->AddClosedDayToEvents($events, $closedDays);

        return response()->json($response);
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

        $duration = $this->worktypeService->GetDurationById($validated['workId']);

        $status = $this->dateService->ValidateDateForEvent($validated['start'], $validated['end'], $duration);

        if ($status['isDateWrong']) {
            return back()->with('error', $status['errorMessage']);
        }

        $this->eventService->createEvent($validated, auth()->id());

        return redirect('/dashboard')->with('success', 'Appointment successfully saved.');
    }
}
