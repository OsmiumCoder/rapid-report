<?php

use App\Http\Controllers\Incident\AssignedIncidentsController;
use App\Http\Controllers\Incident\IncidentController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Incident\OwnedIncidentsController;

Route::resource('incidents', IncidentController::class)->only([
    "create",
    "store"
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('incidents', IncidentController::class)->except([
        "create",
        "store"
    ]);

    Route::get('/owned', OwnedIncidentsController::class)->name('incidents.owned');
    Route::get('/assigned', AssignedIncidentsController::class)->name('incidents.assigned');
});


