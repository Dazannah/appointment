<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return view('welcome');
})->name('welcome');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'getDashboard'])->name('dashboard');
    Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');
    Route::get('/get-events', [CalendarController::class, 'getEvents'])->name('getEvents');
    Route::get('/get-available-work-types', [CalendarController::class, 'getAvailableWorkTypes'])->name('getAvailableWorkTypes');
    //Route::get('/make-reservation', [CalendarController::class, 'getCreateEvent'])->name('getCreateEvent');
    Route::post('/make-reservation', [CalendarController::class, 'createEvent'])->name('createEvent');
    Route::get('/event/{event}', [EventController::class, 'edit']);
    Route::patch('/event/{event}', [EventController::class, 'update']);
    Route::delete('/event/{event}', [EventController::class, 'destroy']);
});

Route::prefix('admin')->middleware(['auth', 'verified', Admin::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'getDashboard'])->name('adminDashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
