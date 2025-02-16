<?php

namespace Tests\Feature\User;

use App\Enum\RolesEnum;
use App\Models\User;
use App\StorableEvents\User\UserRoleUpdated;
use Illuminate\Support\Facades\Event;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_bad_role_throws_validation()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $user = User::factory()->create()->syncRoles(RolesEnum::USER->value);

        $response = $this->patch(route('users.update-role', ['user' => $user->id]), ['role' => 'bad role']);

        $this->assertInstanceOf(ValidationException::class, $response->exception);
    }

    public function test_fires_user_role_updated_event()
    {
        Event::fake();

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $user = User::factory()->create();

        $response = $this->patch(route('users.update-role', ['user' => $user->id]), ['role' => RolesEnum::ADMIN->value]);

        Event::assertDispatchedTimes(UserRoleUpdated::class, 1);

        Event::assertDispatched(function (UserRoleUpdated $event) use ($user) {
            return $user->id == $event->user_id && $event->role == RolesEnum::ADMIN;
        });
    }

    public function test_updates_user_role()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $user = User::factory()->create()->syncRoles(RolesEnum::USER->value);

        $this->assertTrue($user->hasRole(RolesEnum::USER->value));
        $this->assertFalse($user->hasRole(RolesEnum::ADMIN->value));

        $response = $this->patch(route('users.update-role', ['user' => $user->id]), ['role' => RolesEnum::ADMIN->value]);

        $user->refresh();

        $this->assertFalse($user->hasRole(RolesEnum::USER->value));
        $this->assertTrue($user->hasRole(RolesEnum::ADMIN->value));
    }

    public function test_forbidden_to_update_role_of_self()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->patch(route('users.update-role', ['user' => $admin->id]), ['role' => RolesEnum::ADMIN->value]);

        $response->assertForbidden();
    }

    public function test_user_forbidden_to_update_role()
    {
        $user = User::factory()->create()->assignRole('user');

        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $response = $this->patch(route('users.update-role', ['user' => $otherUser->id]), ['role' => RolesEnum::ADMIN->value]);

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_update_role()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $user = User::factory()->create();

        $response = $this->patch(route('users.update-role', ['user' => $user->id]), ['role' => RolesEnum::ADMIN->value]);

        $response->assertForbidden();
    }
}
