<?php

use App\Http\Controllers\Incident\AssignedIncidentsController;
use App\Http\Controllers\Incident\IncidentCommentController;
use App\Http\Controllers\Incident\IncidentController;
use App\Http\Controllers\Incident\IncidentStatusController;
use App\Http\Controllers\Incident\OwnedIncidentsController;
use App\Http\Controllers\Incident\SupervisorAssignmentController;
use Illuminate\Support\Facades\Route;

Route::resource('incidents', IncidentController::class)->only([
    'create',
    'store'
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/incidents/owned', OwnedIncidentsController::class)->name('incidents.owned');
    Route::get('/incidents/assigned', AssignedIncidentsController::class)->name('incidents.assigned');
    Route::put('/incidents/{incident}/assign', [SupervisorAssignmentController::class, 'assignSupervisor'])->name('incidents.assign-supervisor');
    Route::put('/incidents/{incident}/unassign', [SupervisorAssignmentController::class, 'unassignSupervisor'])->name('incidents.unassign-supervisor');
    Route::put('/incidents/{incident}/reopen', [IncidentStatusController::class, 'reopenIncident'])->name('incidents.reopen');
    Route::put('/incidents/{incident}/close', [IncidentStatusController::class, 'closeIncident'])->name('incidents.close');

    Route::resource('incidents', IncidentController::class)->except([
        'create',
        'store'
    ]);

    Route::post('/incidents/{incident}/comments', IncidentCommentController::class)->name('incidents.comments.store');
});
