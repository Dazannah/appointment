<?php

namespace App\Http\Controllers;

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

class AdminController extends Controller {
    private IDate $dateService;
    private IEvent $eventService;
    private IDataSerialisation $dataSerialisationService;
    private IUserService $userService;
    private IWorktypeService $worktypeService;

    public function __construct(IDate $dateService, IEvent $eventService, IDataSerialisation $dataSerialisationService, IUserService $userService, IWorktypeService $worktypeService) {
        $this->dateService = $dateService;
        $this->eventService = $eventService;
        $this->dataSerialisationService = $dataSerialisationService;
        $this->userService = $userService;
        $this->worktypeService = $worktypeService;
    }

    public function getAllAppointmentsForUser(User $user) {
        return view('user-all-events', ['pageTitle' => "All appointments of $user->name", 'reservations' => $this->eventService->getAllEventsOfUser($user)]);
    }

    public function getAdminMenuWorktypes(Request $req) {
        $validated = $req->validate([
            'worktypeId' => '',
            'name' => '',
            'duration' => '',
            'priceId' => '',
        ]);

        $worktypes = $this->worktypeService->getFilterWorktypes($validated);

        return view('admin-menu-worktypes', ['pageTitle' => 'Worktypes', 'worktypes' => $worktypes, 'prices' => Price::all()]);
    }

    public function getSiteSettings() {
        return view('site-settings', ['pageTitle' => 'Site settings']);
    }

    public function getAdminMenuEvents(Request $req) {
        $validated = $req->validate([
            'appointmentId' => '',
            'userName' => '',
            'createdAt' => '',
            'status' => '',
            'workType' => '',
        ]);

        $events = $this->eventService->getAdminMenuFilterEvents($validated);

        return view('admin-menu-events', ['pageTitle' => 'Search appointment', 'events' => $events, 'statuses' => Status::all(), 'workTypes' => WorkTypes::all()]);
    }

    public function getAdminMenuUsers(Request $req) {
        $validated = $req->validate([
            'userId' => '',
            'name' => '',
            'email' => '',
            'status' => '',
            'isAdmin' => '',
        ]);

        $users = $this->userService->getAdminMenuFilterUsers($validated);

        return view('admin-menu-users', ['pageTitle' => 'Search users', 'users' => $users, 'statuses' => UserStatus::all()]);
    }

    public function getAdminMenu() {
        return view('admin-menu', ['pageTitle' => "Admin menu"]);
    }

    public function saveEditEvent(Event $event, Request $req) {
        $validated = $req->validate([
            'userNote' => '',
            'adminNote' => '',
            'status' => 'required'
        ]);

        $this->dataSerialisationService->serialiseInputForEditEvent($validated, $event);
        $event->save();

        return back()->with('success', 'Updated successfully!');
    }

    public function getEditEvent(Event $event) {
        return view('edit-event', ['event' => $event, 'statuses' => Status::all(), 'pageTitle' => "Edit $event->title"]);
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

    public function getEditUser(User $user) {
        $latest10Appointments = $this->eventService->getLatest10AppointmentsForUser($user->id);
        $this->dateService->replaceTInStartEnd($latest10Appointments);

        return view('edit-user', ['user' => $user, 'statuses' => UserStatus::get(), 'latestAppointments' => $latest10Appointments, 'pageTitle' => "Edit $user->name"]);
    }

    public function saveEditUser(User $user, Request $req) {
        $validated = $req->validate([
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

        return back()->with('success', 'User successfully updated.');
    }
}
