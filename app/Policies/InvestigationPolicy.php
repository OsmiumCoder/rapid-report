<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\States\IncidentStatus\Assigned;

class InvestigationPolicy
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
    public function view(User $user, Investigation $investigation): bool
    {
        if ($user->can('view any investigation')) {
            return true;
        }

        if ($investigation->supervisor_id == $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Incident $incident): bool
    {
        if ($user->can('provide investigations') && $incident->supervisor_id == $user->id && $incident->status::class == Assigned::class) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Investigation $investigation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Investigation $investigation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Investigation $investigation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Investigation $investigation): bool
    {
        return false;
    }
}
