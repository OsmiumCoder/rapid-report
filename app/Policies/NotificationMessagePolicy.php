<?php

namespace App\Policies;

use App\Models\NotificationMessage;
use App\Models\User;

class NotificationMessagePolicy
{
    public function update(User $user, NotificationMessage $notificationMessage): bool
    {
        return $user->can('perform admin actions');
    }
}
