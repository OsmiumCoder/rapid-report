<?php

use App\Http\Controllers\InvestigationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('investigations', InvestigationController::class);
});
