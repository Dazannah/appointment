<?php

use App\Models\User;
use App\Models\Event;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\WorkTypesController;

Route::get('/prices', [WorkTypesController::class, 'index']);
Route::get('/get-events', [CalendarController::class, 'getEvents']);

Route::prefix('token')->group(function () {
    Route::post('create', [TokenController::class, 'create']);
    Route::get('get-tokens', [TokenController::class, 'getTokens'])->middleware(['auth:sanctum', 'verified']);
    Route::delete('delete', [TokenController::class, 'delete'])->middleware(['auth:sanctum', 'verified']);
    Route::patch('update', [TokenController::class, 'update'])->middleware(['auth:sanctum', 'verified']);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [ProfileController::class, 'getDashboard']);
    Route::get('/get-available-work-types', [CalendarController::class, 'getAvailableWorkTypes']);
    Route::get('/next-available-time-for-appointement/{worktype}', [CalendarController::class, 'getNextAvailableEventTime']);
    Route::post('/make-reservation', [CalendarController::class, 'createEvent']);
    Route::get('/event/{event}', [EventController::class, 'edit'])->can('edit', 'event');
    Route::patch('/event/{event}', [EventController::class, 'update'])->can('update', 'event');
    Route::delete('/event/{event}', [EventController::class, 'destroy'])->can('destroy', 'event');
});

/*
Route::name('admin.')->prefix('admin')->middleware(['auth', 'verified', Admin::class])->group(function () {
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

    Route::name('closedDays.')->prefix('closed-days')->group(function () {
        Route::get('/create', [ClosedDayController::class, 'create'])->name('createClosedDay');
        Route::post('/create', [ClosedDayController::class, 'store']);
        Route::delete('/delete/{closedDay}', [ClosedDayController::class, 'destroy']);
    });

    Route::name('price.')->prefix('price')->group(function () {
        Route::get('/create', [PriceController::class, 'create'])->name('createPrice');
        Route::post('/create', [PriceController::class, 'store']);
        Route::get('/isPrice/{price:price}', [PriceController::class, 'isPrice'])->name('isPrice');
    });

    Route::get('/site-settings', [SiteConfigController::class, 'index'])->name('siteSettings');
    Route::post('/site-settings', [SiteConfigController::class, 'saveSettings']);
    Route::post('/site-settings/fill-holidays', [SiteConfigController::class, 'fillHolidays']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

*/
