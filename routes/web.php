<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MemberProfileController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->name('auth.')->group(function () {
    Route::get('/', 'login')->name('login');
    Route::post('/authenticate', 'authenticate')->name('authenticate');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::controller(EventController::class)
        ->name('event.')
        ->prefix('event')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/view-event/{id}', 'eventDetails')->name('view');
            Route::post('/status/{id}', 'updateStatus')->name('status');
        });

    Route::controller(MemberProfileController::class)
        ->name('member-profile.')
        ->prefix('member-profile')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/view/{id}', 'view')->name('view');
            Route::post('/status/{id}', 'updateStatus')->name('status');
        });
});

require __DIR__.'/auth.php';
