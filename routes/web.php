<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {
    Route::resource('flights', App\Http\Controllers\FlightController::class);
    Route::resource('reservations', App\Http\Controllers\ReservationController::class);
    Route::get('admin/reports', [App\Http\Controllers\ReportsController::class, 'index'])
        ->middleware('role:admin')
        ->name('admin.reports');
});

require __DIR__.'/auth.php';
