<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\DateInterface;
use App\EventInterface;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller {
    private DateInterface $dateService;
    private EventInterface $eventService;

    public function __construct(DateInterface $dateService, EventInterface $eventService) {
        $this->dateService = $dateService;
        $this->eventService = $eventService;
    }

    public function getDashboard(Request $req) {
        $thisWeekData = $this->eventService->getWeeklyData('last');
        $thisWeekData->title = "This week";
        $nextWeekData = $this->eventService->getWeeklyData('next');
        $nextWeekData->title = "Next week";

        $weeksData = (object)array('thisWeek' => $thisWeekData, 'nextWeek' => $nextWeekData);

        $latest10Appointments = $this->eventService->getLatest10Appointments();
        $this->dateService->replaceTInStartEnd($latest10Appointments);

        $latest10Users = User::getLatest10UsersRegistration();

        return view('admin-dashboard', ['weeksData' => $weeksData, 'latestAppointments' => $latest10Appointments, 'latest10Users' => $latest10Users, 'pageTitle' => "Admin dashboard"]);
    }
}
