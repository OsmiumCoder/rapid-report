<?php

use App\Http\Controllers\Incident\AssignedIncidentsController;
use App\Http\Controllers\Incident\IncidentCommentController;
use App\Http\Controllers\Incident\IncidentController;
use App\Http\Controllers\Incident\IncidentStatusController;
use App\Http\Controllers\Incident\OwnedIncidentsController;
use App\Http\Controllers\Incident\SearchIncidentsController;
use Illuminate\Support\Facades\Route;

Route::resource('incidents', IncidentController::class)->only([
    'create',
    'store'
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/incidents/search', SearchIncidentsController::class)->name('incidents.search');

    Route::get('/incidents/owned', OwnedIncidentsController::class)->name('incidents.owned');
    Route::get('/incidents/assigned', AssignedIncidentsController::class)->name('incidents.assigned');

    Route::patch('/incidents/{incident}/assign', [IncidentStatusController::class, 'assignSupervisor'])->name('incidents.assign-supervisor');
    Route::patch('/incidents/{incident}/unassign', [IncidentStatusController::class, 'unassignSupervisor'])->name('incidents.unassign-supervisor');
    Route::patch('/incidents/{incident}/return-investigation', [IncidentStatusController::class, 'returnInvestigation'])->name('incidents.return-investigation');
    Route::patch('/incidents/{incident}/return-rca', [IncidentStatusController::class, 'returnInvestigation'])->name('incidents.return-rca');
    Route::patch('/incidents/{incident}/close', [IncidentStatusController::class, 'closeIncident'])->name('incidents.close');
    Route::patch('/incidents/{incident}/reopen', [IncidentStatusController::class, 'reopenIncident'])->name('incidents.reopen');

    Route::resource('incidents', IncidentController::class)->except([
        'create',
        'store'
    ]);

    Route::post('/incidents/{incident}/comments', IncidentCommentController::class)->name('incidents.comments.store');

});
