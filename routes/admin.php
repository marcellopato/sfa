<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;
use App\Livewire\Admin\UsersManagement;

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/reports', [ReportsController::class, 'index'])->name('reports');
    Route::get('/users', UsersManagement::class)->name('users');
}); 