<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Interfaces\IEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ProfileController extends Controller {
    protected IEvent $eventService;

    public function __construct(IEvent $eventService) {
        $this->eventService = $eventService;
    }

    public function getDashboard(Request $request) {
        $reservations = $this->eventService->getOwnEvents(auth()->user()->id);

        $responseArray = ['reservations' => $reservations, 'pageTitle' => auth()->user()->name . "'s reservations"];
        if ($request->wantsJson())
            return response()->json($responseArray);
        else
            return view('dashboard', $responseArray);
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request) {
        $responseArray = ['user' => $request->user(), 'pageTitle' => $request->user()->name];

        if ($request->wantsJson())
            return response()->json($responseArray);
        return view('profile.edit', $responseArray);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request) {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if ($request->wantsJson())
            return response()->json(["success" => "Profile sucessfully updated"]);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request) {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if (!$request->wantsJson())
            Auth::logout();

        $user->delete();

        if (!$request->wantsJson()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        if ($request->wantsJson())
            return response()->json(["seccess" => "User successfully deleted."]);

        return Redirect::to('/');
    }
}
