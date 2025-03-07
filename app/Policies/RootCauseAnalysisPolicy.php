<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Returned;

class RootCauseAnalysisPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RootCauseAnalysis $rootCauseAnalysis): bool
    {
        if ($user->can('view any incident follow-up')) {
            return true;
        }

        if ($rootCauseAnalysis->supervisor_id == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Incident $incident): bool
    {
        return (
            $user->can('provide incident follow-up')
            && $incident->supervisor_id == $user->id
            && (
                $incident->status::class == Assigned::class
                || $incident->status::class == Returned::class
            )
        );
    }
}
