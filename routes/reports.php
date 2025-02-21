<?php

use App\Http\Controllers\Report\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/stats', [ReportController::class, 'stats'])->name('report.stats');
    Route::post('/report/downloadFileCSV', [ReportController::class, 'downloadFileCSV'])->name('report.downloadFileCSV');
    Route::post('/report/downloadFileXL', [ReportController::class, 'downloadFileXLSX'])->name('report.downloadFileXLSX');
});
