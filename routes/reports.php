<?php

use App\Http\Controllers\Reports\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/reports/show', [ReportController::class, 'show'])->name('reports.show');
});
