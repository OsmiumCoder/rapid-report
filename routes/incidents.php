<?php

use App\Http\Controllers\Incident\AssignedIncidentsController;
use App\Http\Controllers\Incident\IncidentController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Incident\OwnedIncidentsController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('incidents', IncidentController::class)->except([
        "create",
        "store"
    ]);

    Route::get('incidents/owned', OwnedIncidentsController::class)->name('incidents.owned');
    Route::get('incidents/assigned', AssignedIncidentsController::class)->name('incidents.assigned');
});

Route::resource('incidents', IncidentController::class)->only([
    "create",
    "store"
]);
