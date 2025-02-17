<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\States\IncidentStatus\Assigned;

class RootCauseAnalysisPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RootCauseAnalysis $rootCauseAnalysis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Incident $incident): bool
    {
        if ($user->can('provide incident follow-up') && $incident->supervisor_id == $user->id && $incident->status::class == Assigned::class) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RootCauseAnalysis $rootCauseAnalysis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RootCauseAnalysis $rootCauseAnalysis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RootCauseAnalysis $rootCauseAnalysis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RootCauseAnalysis $rootCauseAnalysis): bool
    {
        return false;
    }
}
