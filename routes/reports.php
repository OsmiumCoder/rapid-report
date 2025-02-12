<?php

use App\Http\Controllers\Report\ReportController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/download-file/{filename}', [ReportController::class, 'download_file_csv'])->name('download.download_file_csv');
});
