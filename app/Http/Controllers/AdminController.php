<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\DateInterface;
use App\Models\Status;
use App\EventInterface;
use App\Models\UserStatus;
use Illuminate\Http\Request;

class AdminController extends Controller {
    private DateInterface $dateService;
    private EventInterface $eventService;

    public function __construct(DateInterface $dateService, EventInterface $eventService) {
        $this->dateService = $dateService;
        $this->eventService = $eventService;
    }

    public function getAdminMenuEvents(Request $req) {
        return view('admin-menu-events', ['pageTitle' => 'Search appointment']);
    }

    public function getAdminMenuUsers(Request $req) {
        $validated = $req->validate([
            'userId' => '',
            'name' => '',
            'email' => '',
            'status' => '',
            'isAdmin' => '',
        ]);

        $users = User::when(
            isset($validated['userId']),
            function ($querry) use ($validated) {
                return $querry->where('id', 'REGEXP', $validated['userId']);
            }
        )->when(
            isset($validated['name']),
            function ($querry) use ($validated) {
                return $querry->where('name', 'REGEXP', $validated['name']);
            }
        )->when(
            isset($validated['email']),
            function ($querry) use ($validated) {
                return $querry->where('email', 'REGEXP', $validated['email']);
            }
        )->when(
            isset($validated['status']) && ($validated['status'] != 0),
            function ($querry) use ($validated) {
                return $querry->where('user_status_id', '=', $validated['status']);
            }
        )->where(
            'is_admin',
            '=',
            isset($validated['isAdmin'])
        )->paginate(10);

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

        $event->note = $validated['userNote'];
        $event->admin_note = $validated['adminNote'];
        $event->status_id = $validated['status'];
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

        $latest10Users = User::getLatest10UsersRegistration();

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

        $user->name = $validated['fullName'];
        $user->created_at = $validated['createdAt'];
        $user->updated_at = $validated['updatedAt'];
        $user->email = $validated['emailAddress'];
        $user->user_status_id = $validated['status'];
        $user->updated_by = auth()->user()->id;

        if (isset($validated['isAdmin']) && ($validated['isAdmin'] === 'on')) {
            $user->is_admin = 1;
        } else {
            $user->is_admin = 0;
        }

        $user->save();

        return back()->with('success', 'User successfully updated.');
    }
}
