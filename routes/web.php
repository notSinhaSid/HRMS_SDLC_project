<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\NoCache;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', NoCache::class])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// these routes are for RBAC testing only, actual will be implemented later
Route::middleware(['auth'])->prefix('test')->group(function() {
    Route::get('/employee-view', fn() => 'Ok: employee.view')->middleware('can:employee.view');
});