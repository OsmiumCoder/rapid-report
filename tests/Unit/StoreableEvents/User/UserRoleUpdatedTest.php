<?php

namespace StoreableEvents\User;

use App\Enum\RolesEnum;
use App\Models\User;
use App\StorableEvents\User\UserRoleUpdated;
use Tests\TestCase;

class UserRoleUpdatedTest extends TestCase
{
    public function test_updates_user_role()
    {
        $user = User::factory()->create()->syncRoles(RolesEnum::USER->value);

        $event = new UserRoleUpdated(
            user_id: $user->id,
            role: RolesEnum::ADMIN
        );

        $this->assertTrue($user->hasRole(RolesEnum::USER->value));
        $this->assertFalse($user->hasRole(RolesEnum::ADMIN->value));

        $event->handle();

        $user->refresh();

        $this->assertFalse($user->hasRole(RolesEnum::USER->value));
        $this->assertTrue($user->hasRole(RolesEnum::ADMIN->value));
    }
}
