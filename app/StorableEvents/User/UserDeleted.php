<?php

namespace App\StorableEvents\User;

use App\Models\User;
use App\StorableEvents\StoredEvent;

class UserDeleted extends StoredEvent
{
    public function __construct(
        public int $id,
    ) {
    }

    public function handle()
    {
        $user = User::find($this->id);

        $user->delete();
    }
}
