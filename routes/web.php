<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'getDashboard'])->name('dashboard');
    Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');
    Route::get('/get-events', [CalendarController::class, 'getEvents'])->name('getEvents');
    Route::get('/make-reservation', [CalendarController::class, 'getCreateEvent'])->name('getCreateEvent');
    Route::post('/make-reservation', [CalendarController::class, 'createEvent'])->name('createEvent');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
