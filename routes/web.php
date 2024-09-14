<?php

use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\SiteConfigController;
use App\Http\Controllers\WorkTypesController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/dashboard');
    }

    return view('welcome');
})->name('welcome');

Route::get('/prices', [WorkTypesController::class, 'index'])->name('prices');
Route::get('/calendar', [CalendarController::class, 'show'])->name('calendar');
Route::get('/get-events', [CalendarController::class, 'getEvents'])->name('getEvents');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'getDashboard'])->name('dashboard');
    Route::get('/get-available-work-types', [CalendarController::class, 'getAvailableWorkTypes'])->name('getAvailableWorkTypes');
    Route::get('/next-available-time-for-appointement/{worktype}', [CalendarController::class, 'getNextAvailableEventTime'])->name('getNextAvailableEventTime');
    //Route::get('/make-reservation', [CalendarController::class, 'getCreateEvent'])->name('getCreateEvent');
    Route::post('/make-reservation', [CalendarController::class, 'createEvent'])->name('createEvent');
    Route::get('/event/{event}', [EventController::class, 'edit']);
    Route::patch('/event/{event}', [EventController::class, 'update']);
    Route::delete('/event/{event}', [EventController::class, 'destroy']);
});

Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified', Admin::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'getDashboard'])->name('dashboard');

    Route::name('user.')->prefix('user')->group(function () {
        Route::get('/{user}', [AdminController::class, 'getEditUser']);
        Route::patch('/{user}', [AdminController::class, 'saveEditUser']);
        Route::get('/{user}/all-appointments', [AdminController::class, 'getAllAppointmentsForUser'])->name('getAllAppointments');
    });

    Route::get('/event/{event}', [AdminController::class, 'getEditEvent']);
    Route::patch('/event/{event}', [AdminController::class, 'saveEditEvent']);

    Route::name('menu.')->prefix('menu')->group(function () {
        Route::get('/', [AdminController::class, 'getAdminMenu'])->name('base');
        Route::get('/users', [AdminController::class, 'getAdminMenuUsers'])->name('users');
        Route::get('/events', [AdminController::class, 'getAdminMenuEvents'])->name('events');
        Route::get('/worktypes', [AdminController::class, 'getAdminMenuWorktypes'])->name('worktypes');
        Route::get('/closed-days', [AdminController::class, 'getAdminMenuClosedDays'])->name('closedDays');
    });

    Route::name('worktype.')->prefix('worktype')->group(function () {
        Route::get('/create', [WorkTypesController::class, 'create'])->name('createWorktype');
        Route::post('/create', [WorkTypesController::class, 'store']);
        Route::get('/{worktype}', [WorkTypesController::class, 'edit'])->name('editWorktype');
        Route::patch('/{worktype}', [WorkTypesController::class, 'update'])->name('showWorktype');
        Route::delete('/delete/{worktype}', [WorkTypesController::class, 'destroy'])->name('deleteWorktype');
    });

    Route::name('price.')->prefix('price')->group(function () {
        Route::get('/create', [PriceController::class, 'create'])->name('createPrice');
        Route::post('/create', [PriceController::class, 'store']);
        Route::get('/isPrice/{price:price}', [PriceController::class, 'isPrice'])->name('isPrice');
    });

    Route::get('/site-settings', [SiteConfigController::class, 'index'])->name('siteSettings');
    Route::post('/site-settings', [SiteConfigController::class, 'saveSettings']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
