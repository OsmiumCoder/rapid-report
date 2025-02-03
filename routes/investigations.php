<?php

use App\Http\Controllers\Investigation\InvestigationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('investigations', InvestigationController::class)->except(['index']);
});
