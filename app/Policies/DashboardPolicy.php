<?php

namespace App\Policies;

use App\Models\User;

class DashboardPolicy
{
    public function viewAdminOverview(User $user)
    {
        return $user->can('perform admin actions');
    }

    public function viewSupervisorOverview(User $user)
    {
        return $user->can('view assigned incidents');
    }

    public function viewUserManagement(User $user)
    {
        return $user->can('perform admin actions');
    }
}
