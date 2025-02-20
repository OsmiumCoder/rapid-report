<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// TODO: Remove, used for demo purposes
Route::get('/notification', function () {
    $supervisor = \App\Models\User::factory()->create()->syncRoles('supervisor');
    $incident = \App\Models\Incident::factory()->create();
    $investigation = \App\Models\Investigation::factory()->create();
    $rca = \App\Models\RootCauseAnalysis::factory()->create();

    $incidentReceived = new \App\Mail\IncidentReceived;
    $userAdded = new \App\Mail\UserAdded;

    $incidentSubmitted = new \App\Notifications\Incident\IncidentSubmitted(
        incidentId: $incident->id,
        firstName: null,
        lastName: null,
    );

    $investigationSubmitted = new \App\Notifications\Investigation\InvestigationSubmitted(
        incidentId: $incident->id,
        investigationId: $investigation->id,
        supervisor: $supervisor,
    );

    $rcaSubmitted = new \App\Notifications\RootCauseAnalysis\RootCauseAnalysisSubmitted(
        incidentId: $incident->id,
        rootCauseAnalysisId: $rca->id,
        supervisor: $supervisor,
    );

    return $incidentReceived->render();
    // return $userAdded->render();
    // return $incidentSubmitted->toMail($supervisor);
    // return $investigationSubmitted->toMail($supervisor);
    // return $rcaSubmitted->toMail($supervisor);

});

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/admin', [DashboardController::class, 'adminOverview'])->name('dashboard.admin');
    Route::get('/dashboard/supervisor', [DashboardController::class, 'supervisorOverview'])->name('dashboard.supervisor');
    Route::get('/dashboard/user-management', [DashboardController::class, 'userManagement'])->name('dashboard.user-management');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/incidents.php';
require __DIR__ . '/investigations.php';
require __DIR__ . '/notifications.php';
require __DIR__ . '/root-cause-analyses.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/users.php';
