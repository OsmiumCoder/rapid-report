<?php

namespace App\Policies;

use App\Models\User;

class ReportPolicy
{
    public function viewAll(User $user): bool
    {
        dd("Report");
        return $user->can('view reports');
    }
}
