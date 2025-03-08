<?php

namespace App\Policies;

use App\Models\User;

class DashboardPolicy
{
    public function viewAdminOverview(User $user): bool
    {
        return $user->can('perform admin actions');
    }

    public function viewSupervisorOverview(User $user): bool
    {
        return $user->can('view assigned incidents');
    }

    public function viewUserManagement(User $user): bool
    {
        return $user->can('perform admin actions');
    }

    public function viewSettings(User $user): bool
    {
        return $user->can('perform admin actions');
    }
}
