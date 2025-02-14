<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('manage users');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        if ($user->can('manage users') && $user->id !== $model->id) {
            return true;
        }

        return false;
    }

    public function updateRole(User $user, User $model)
    {
        if ($user->can('manage users') && $user->id !== $model->id) {
            return true;
        }

        return false;
    }
}
