<?php

use App\Models\User;
use App\Models\Event;
use App\Http\Middleware\Admin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ClosedDayController;
use App\Http\Controllers\WorkTypesController;
use App\Http\Controllers\SiteConfigController;

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

// documentation needed
Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum', 'verified', Admin::class])->group(function () {
    Route::name('user.')->prefix('user')->group(function () {
        Route::get('/{user}', [AdminController::class, 'getEditUser']);
        Route::patch('/{user}', [AdminController::class, 'saveEditUser']);
        Route::get('/{user}/all-appointments', [AdminController::class, 'getAllAppointmentsForUser']);
    });

    Route::name('event.')->prefix('event')->group(function () {
        Route::get('/{event}', [AdminController::class, 'getEditEvent']);
        Route::patch('/{event}', [AdminController::class, 'saveEditEvent']);
    });


    Route::name('menu.')->prefix('menu')->group(function () {
        Route::get('/users', [AdminController::class, 'getAdminMenuUsers']);
        Route::get('/events', [AdminController::class, 'getAdminMenuEvents']);
        Route::get('/worktypes', [AdminController::class, 'getAdminMenuWorktypes']);
        Route::get('/closed-days', [AdminController::class, 'getAdminMenuClosedDays']);
    });

    Route::name('worktype.')->prefix('worktype')->group(function () {
        Route::post('/create', [WorkTypesController::class, 'store']);
        Route::get('/{worktype}', [WorkTypesController::class, 'edit']);
        Route::patch('/{worktype}', [WorkTypesController::class, 'update']);
        Route::delete('/{worktype}', [WorkTypesController::class, 'destroy']);
    });

    // Route::name('closedDays.')->prefix('closed-days')->group(function () {
    //     Route::get('/create', [ClosedDayController::class, 'create'])->name('createClosedDay');
    //     Route::post('/create', [ClosedDayController::class, 'store']);
    //     Route::delete('/delete/{closedDay}', [ClosedDayController::class, 'destroy']);
    // });

    // Route::name('price.')->prefix('price')->group(function () {
    //     Route::get('/create', [PriceController::class, 'create'])->name('createPrice');
    //     Route::post('/create', [PriceController::class, 'store']);
    //     Route::get('/isPrice/{price:price}', [PriceController::class, 'isPrice'])->name('isPrice');
    // });

    // Route::get('/site-settings', [SiteConfigController::class, 'index'])->name('siteSettings');
    // Route::post('/site-settings', [SiteConfigController::class, 'saveSettings']);
    // Route::post('/site-settings/fill-holidays', [SiteConfigController::class, 'fillHolidays']);
});

/*

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

*/
