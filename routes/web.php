<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// TODO: Test for demo purposes
Route::get('/notification', function () {
    return (new \App\Mail\IncidentReceived)->render();
});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminOverview'])->name('dashboard.admin');
    Route::get('/dashboard/supervisor', [DashboardController::class, 'supervisorOverview'])->name('dashboard.supervisor');
    Route::get('/dashboard/user-management', [DashboardController::class, 'userManagement'])->name('dashboard.user-management');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
require __DIR__.'/reports.php';
require __DIR__.'/incidents.php';
require __DIR__.'/investigations.php';
require __DIR__.'/root-cause-analysis.php';
require __DIR__.'/notifications.php';
require __DIR__.'/users.php';
