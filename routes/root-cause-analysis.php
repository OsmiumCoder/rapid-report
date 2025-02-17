<?php

use App\Http\Controllers\RootCauseAnalysis\RootCauseAnalysisController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('incidents.root-cause-analysis', RootCauseAnalysisController::class)->except(['index']);
});
