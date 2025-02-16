<?php

namespace App\StorableEvents\User;

use App\Models\User;
use App\StorableEvents\StoredEvent;

class UserDeleted extends StoredEvent
{
    public function __construct(
        public int $user_id,
    ) {
    }

    public function handle()
    {
        $user = User::find($this->user_id);

        $user->delete();
    }
}
