<?php

namespace App\StorableEvents\User;

use App\Enum\RolesEnum;
use App\Models\User;
use App\StorableEvents\StoredEvent;

class UserRoleUpdated extends StoredEvent
{
    public function __construct(
        public int $user_id,
        public RolesEnum $role
    ) {
    }

    public function handle()
    {
        $user = User::find($this->user_id);

        $user->syncRoles($this->role->value);
    }
}
