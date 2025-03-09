<?php

use App\Http\Controllers\DashboardController;

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminOverview'])->name('dashboard.admin');
    Route::get('/dashboard/supervisor', [DashboardController::class, 'supervisorOverview'])->name('dashboard.supervisor');
    Route::get('/dashboard/user-management', [DashboardController::class, 'userManagement'])->name('dashboard.user-management');
    Route::get('/dashboard/settings', [DashboardController::class, 'settings'])->name('dashboard.settings');
});
