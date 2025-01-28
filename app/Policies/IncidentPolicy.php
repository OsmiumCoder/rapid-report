<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;

class IncidentPolicy
{
    /**
     * Determine whether the user can view any incidents.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view all incidents');
    }

    public function viewAnyAssigned(User $user): bool
    {
        return $user->can('view assigned incidents');
    }

    public function viewAnyOwned(User $user): bool
    {
        return $user->can('view own incidents');
    }

    /**
     * Determine whether the user can view the incident.
     */
    public function view(User $user, Incident $incident): bool
    {
        if ($user->can('view all incidents')) {
            return true;
        }

        if ($user->can('view assigned incidents') && $user->id == $incident->supervisor_id) {
            return true;
        }

        if ($user->can('view own incidents') && $user->email == $incident->reporters_email) {
            return true;
        }

        return false;
    }

    public function assignSupervisor(User $user): bool
    {
        return $user->can('assign supervisor');
    }

    /**
     * Determine whether the user can create incidents.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the incident.
     */
    public function update(User $user, Incident $incident): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the incident.
     */
    public function delete(User $user, Incident $incident): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the incident.
     */
    public function restore(User $user, Incident $incident): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the incident.
     */
    public function forceDelete(User $user, Incident $incident): bool
    {
        return false;
    }
}
