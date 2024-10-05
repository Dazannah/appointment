<?php

namespace App\Http\Controllers;

use App\Interfaces\IClosedDay;
use App\Models\User;
use App\Models\Event;
use App\Models\Price;
use App\Models\Status;
use App\Interfaces\IDate;
use App\Models\WorkTypes;
use App\Interfaces\IEvent;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use App\Interfaces\IUserService;
use App\Interfaces\IWorktypeService;
use App\Interfaces\IDataSerialisation;
use App\Models\ClosedDay;

class AdminController extends Controller {
    private IDate $dateService;
    private IEvent $eventService;
    private IDataSerialisation $dataSerialisationService;
    private IUserService $userService;
    private IWorktypeService $worktypeService;
    private IClosedDay $closedDaysService;

    public function __construct(IDate $dateService, IEvent $eventService, IDataSerialisation $dataSerialisationService, IUserService $userService, IWorktypeService $worktypeService, IClosedDay $closedDaysService) {
        $this->dateService = $dateService;
        $this->eventService = $eventService;
        $this->dataSerialisationService = $dataSerialisationService;
        $this->userService = $userService;
        $this->worktypeService = $worktypeService;
        $this->closedDaysService = $closedDaysService;
    }

    public function getAdminMenuClosedDays(Request $request) {
        $validated = $request->validate([
            'closedDayId' => '',
            'startDate' => '',
            'endDate' => '',
            'holidays' => '',
            'currentYear' => ''
        ]);

        $closedDays = $this->closedDaysService->getFilterClosedDays($validated);

        $responseArray = ['pageTitle' => 'Closed days', 'closedDays' => $closedDays];

        if ($request->wantsJson())
            return response()->json($responseArray);

        return view('admin-menu-closedDays', $responseArray);
    }

    public function getAllAppointmentsForUser(User $user, Request $request) {
        $responseArray = ['pageTitle' => "All appointments of $user->name", 'reservations' => $this->eventService->getAllEventsOfUser($user)];

        if ($request->wantsJson()) {
            return response()->json($responseArray);
        }

        return view('user-all-events', $responseArray);
    }

    public function getAdminMenuWorktypes(Request $request) {
        $validated = $request->validate([
            'worktypeId' => '',
            'name' => '',
            'duration' => '',
            'priceId' => '',
        ]);

        $worktypes = $this->worktypeService->getFilterWorktypes($validated);

        $responseArray = ['pageTitle' => 'Worktypes', 'worktypes' => $worktypes, 'prices' => Price::all()];

        if ($request->wantsJson())
            return response()->json($responseArray);

        return view('admin-menu-worktypes', $responseArray);
    }

    public function getAdminMenuEvents(Request $request) {
        $validated = $request->validate([
            'appointmentId' => '',
            'userName' => '',
            'createdAt' => '',
            'status' => '',
            'workType' => '',
        ]);

        $events = $this->eventService->getAdminMenuFilterEvents($validated);

        $responseArray = ['pageTitle' => 'Search appointment', 'events' => $events, 'statuses' => Status::all(), 'workTypes' => WorkTypes::all()];

        if ($request->wantsJson())
            return response()->json($responseArray);

        return view('admin-menu-events', $responseArray);
    }

    public function getAdminMenuUsers(Request $requets) {
        $validated = $requets->validate([
            'userId' => '',
            'name' => '',
            'email' => '',
            'status' => '',
            'isAdmin' => '',
        ]);

        $users = $this->userService->getAdminMenuFilterUsers($validated);

        $responseArray = ['pageTitle' => 'Search users', 'users' => $users, 'statuses' => UserStatus::all()];

        if ($requets->wantsJson())
            return response()->json($responseArray);

        return view('admin-menu-users',);
    }

    public function getAdminMenu() {
        return view('admin-menu', ['pageTitle' => "Admin menu"]);
    }

    public function saveEditEvent(Event $event, Request $request) {
        $validated = $request->validate([
            'userNote' => '',
            'adminNote' => '',
            'status' => 'required'
        ]);

        $this->dataSerialisationService->serialiseInputForEditEvent($validated, $event);
        $event->save();

        if ($request->wantsJson())
            return response()->json(['success' => 'Updated successfully!']);

        return back()->with('success', 'Updated successfully!');
    }

    public function getEditEvent(Event $event, Request $request) {
        $responseArray = ['event' => $event, 'statuses' => Status::all(), 'pageTitle' => "Edit $event->title"];

        if ($request->wantsJson())
            return response()->json($responseArray);

        return view('edit-event', $responseArray);
    }

    public function getDashboard(Request $req) {
        $thisWeekData = $this->eventService->getWeeklyData('last');
        $thisWeekData->title = "This week";
        $nextWeekData = $this->eventService->getWeeklyData('next');
        $nextWeekData->title = "Next week";

        $weeksData = (object)array('thisWeek' => $thisWeekData, 'nextWeek' => $nextWeekData);

        $latest10Appointments = $this->eventService->getLatest10Appointments();
        $this->dateService->replaceTInStartEnd($latest10Appointments);

        $latest10Users = $this->userService->getLatest10UsersRegistration();

        return view('admin-dashboard', ['weeksData' => $weeksData, 'latestAppointments' => $latest10Appointments, 'latest10Users' => $latest10Users, 'pageTitle' => "Admin dashboard"]);
    }

    public function getEditUser(User $user, Request $request) {
        $latest10Appointments = $this->eventService->getLatest10AppointmentsForUser($user->id);
        $this->dateService->replaceTInStartEnd($latest10Appointments);

        $responseArray = ['user' => $user, 'statuses' => UserStatus::get(), 'latestAppointments' => $latest10Appointments, 'pageTitle' => "Edit $user->name"];
        if ($request->wantsJson()) {
            return response()->json($responseArray);
        }

        return view('edit-user', $responseArray);
    }

    public function saveEditUser(User $user, Request $request) {
        $validated = $request->validate([
            'fullName' => 'required',
            'createdAt' => 'required|date',
            'updatedAt' => 'required|date',
            'emailAddress' => 'required|email',
            'status' => 'required',
            'isEmailVerified' => '',
            'isAdmin' => ''
        ]);

        $this->dataSerialisationService->serialiseInputForEditUser($validated, $user);

        $user->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => 'User successfully updated.']);
        }

        return back()->with('success', 'User successfully updated.');
    }
}
