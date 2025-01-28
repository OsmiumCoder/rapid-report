<?php

use App\Http\Controllers\Incident\AssignedIncidentsController;
use App\Http\Controllers\Incident\AssignSupervisorController;
use App\Http\Controllers\Incident\IncidentCommentController;
use App\Http\Controllers\Incident\IncidentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Incident\OwnedIncidentsController;

Route::resource('incidents', IncidentController::class)->only([
    'create',
    'store'
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/incidents/owned', OwnedIncidentsController::class)->name('incidents.owned');
    Route::get('/incidents/assigned', AssignedIncidentsController::class)->name('incidents.assigned');
    Route::put('/incidents/{incident}/assign', AssignSupervisorController::class)->name('incidents.assign-supervisor');

    Route::resource('incidents', IncidentController::class)->except([
        'create',
        'store'
    ]);

    Route::post('/incidents/{incident}/comments', IncidentCommentController::class)->name('incidents.comments.store');
});
