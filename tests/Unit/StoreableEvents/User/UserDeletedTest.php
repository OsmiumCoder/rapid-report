<?php

namespace StoreableEvents\User;

use App\Models\User;
use App\StorableEvents\User\UserDeleted;
use Tests\TestCase;

class UserDeletedTest extends TestCase
{
    public function test_deletes_user()
    {
        $user = User::factory()->create();

        $event = new UserDeleted($user->id);

        $event->handle();

        $user->refresh();

        $this->assertTrue($user->trashed());
    }
}
