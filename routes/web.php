<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

// TODO: Remove, used for demo purposes
Route::get('/notification', function () {
    $admin = \App\Models\User::factory()->create()->syncRoles('admin');
    $supervisor = \App\Models\User::factory()->create()->syncRoles('supervisor');
    $incident = \App\Models\Incident::factory()->create();
    $investigation = \App\Models\Investigation::factory()->create();
    $rca = \App\Models\RootCauseAnalysis::factory()->create();


    $commentMade = new \App\Notifications\Comment\CommentAdded(
        comment: "Some comment",
        user: $supervisor,
        url: route('incidents.show', ['incident' => $incident->slug]),
        incidentSlug: $incident->slug,
    );

    $incidentClosed = new \App\Notifications\Incident\IncidentClosedNotification($incident->slug);
    $followupOverdue = new \App\Notifications\Incident\IncidentFollowUpOverdueNotification(incidentSlug: $incident->slug, supervisor: $supervisor);
    $incidentReopened = new \App\Notifications\Incident\IncidentReopenedNotification($incident->slug);
    $incidentFollowupReview = new \App\Notifications\Incident\IncidentReviewRequestNotification(incidentSlug: $incident->slug, supervisor: $supervisor);
    $incidentReceived = new \App\Mail\IncidentReceived($incident->slug);
    $userAdded = new \App\Mail\UserAdded;

    $incidentSubmitted = new \App\Notifications\Incident\IncidentSubmittedNotification(
        incidentId: $incident->slug,
        firstName: null,
        lastName: null,
    );

    $incidentAssigned = new \App\Notifications\Incident\SupervisorAssignedNotification(
        incidentSlug: $incident->slug,
        admin: $admin,
        supervisor: $supervisor,
    );

    $investigationSubmitted = new \App\Notifications\Investigation\InvestigationSubmittedNotification(
        incidentSlug: $incident->slug,
        investigationId: $investigation->id,
        supervisor: $supervisor,
    );

    $investigationReturned = new \App\Notifications\Investigation\InvestigationReturnedNotification(
        incidentSlug: $incident->slug,
        investigationId: $investigation->id,
        admin: $admin
    );

    $rcaSubmitted = new \App\Notifications\RootCauseAnalysis\RootCauseAnalysisSubmittedNotification(
        incidentSlug: $incident->slug,
        rootCauseAnalysisId: $rca->id,
        supervisor: $supervisor,
    );

    $additionalInfo = new \App\Notifications\Incident\AdditionalInformationNotification($incident->slug, 'Some additional information');
    $filesUploaded = new \App\Notifications\Incident\FilesUploadedNotification($incident->slug, $supervisor);

    //    return $filesUploaded->toMail($supervisor);
    //    return $commentMade->toMail($supervisor);
    //    return $incidentClosed->toMail($supervisor);
    //    return $followupOverdue->toMail($supervisor);
    //    return $incidentReopened->toMail($supervisor);
    //    return $incidentFollowupReview->toMail($supervisor);
    return $incidentReceived->render();
    //    return $userAdded->render();
    //    return $incidentSubmitted->toMail($supervisor);
    //    return $investigationSubmitted->toMail($supervisor);
    //    return $investigationReturned->toMail($supervisor);
    //    return $incidentAssigned->toMail($supervisor);
    //    return $rcaSubmitted->toMail($supervisor);
    //    return $additionalInfo->toMail($supervisor);

});

Route::permanentRedirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/auth/redirect', function () {
    return Socialite::driver('microsoft')
        ->with(['hd' => 'upei.ca'])
        ->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('microsoft')->user();

    dd($user);
    // $user->token
});


require __DIR__ . '/auth.php';
require __DIR__ . '/incidents.php';
require __DIR__ . '/investigations.php';
require __DIR__ . '/notifications.php';
require __DIR__ . '/root-cause-analyses.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/users.php';
require __DIR__ . '/dashboard.php';
