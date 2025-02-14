<?php

namespace Tests\Feature\User;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\StorableEvents\User\UserDeleted;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class DestroyTest extends TestCase
{
    public function test_deletes_user_but_incident_persists()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $response = $this->delete(route('users.destroy', ['user' => $supervisor->id]));

        $supervisor->refresh();

        $this->assertTrue($supervisor->trashed());

        $this->assertFalse($incident->trashed());
    }

    public function test_deletes_user_investigation_persists()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);

        $investigation = Investigation::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id
        ]);

        $response = $this->delete(route('users.destroy', ['user' => $supervisor->id]));

        $supervisor->refresh();

        $this->assertTrue($supervisor->trashed());

        $this->assertFalse($investigation->trashed());
    }

    public function test_fires_user_deleted_event()
    {
        Event::fake();

        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', ['user' => $user->id]));

        Event::assertDispatchedTimes(UserDeleted::class, 1);

        Event::assertDispatched(function (UserDeleted $event) use ($user) {
            return $user->id == $event->id;
        });
    }

    public function test_deletes_user()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', ['user' => $user->id]));

        $user->refresh();

        $this->assertTrue($user->trashed());
    }

    public function test_forbidden_to_delete_self()
    {
        $admin = User::factory()->create()->assignRole('admin');

        $this->actingAs($admin);

        $response = $this->delete(route('users.destroy', ['user' => $admin->id]));

        $response->assertForbidden();
    }

    public function test_user_forbidden_to_delete()
    {
        $user = User::factory()->create()->assignRole('user');

        $this->actingAs($user);

        $otherUser = User::factory()->create();

        $response = $this->delete(route('users.destroy', ['user' => $otherUser->id]));

        $response->assertForbidden();
    }

    public function test_supervisor_forbidden_to_delete()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', ['user' => $user->id]));

        $response->assertForbidden();
    }
}
