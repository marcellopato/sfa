<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\ReservationController;

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

Route::resource('flights', FlightController::class);

Route::resource('flights.reservations', ReservationController::class)
    ->only(['create', 'store'])
    ->middleware('auth');
    
Route::resource('reservations', ReservationController::class)
    ->only(['index', 'show', 'edit', 'update', 'destroy'])
    ->middleware('auth');

require __DIR__.'/auth.php';
