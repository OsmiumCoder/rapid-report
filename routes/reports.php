<?php

use App\Http\Controllers\Report\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/stats', [ReportController::class, 'stats'])->name('report.stats');
    Route::post('/report/export-csv', [ReportController::class, 'exportCSV'])->name('report.export-csv');
    Route::post('/report/export-xlsx', [ReportController::class, 'exportXLSX'])->name('report.export-xlsx');
});
