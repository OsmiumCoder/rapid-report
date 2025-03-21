<?php

namespace Tests\Unit\StoreableEvents\User;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\User\UserDeleted;
use Tests\TestCase;

class UserDeletedTest extends TestCase
{
    public function test_updates_assigned_status_to_open()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $user->id]);

        $event = new UserDeleted($user->id);

        $event->handle();

        $incident->refresh();

        $this->assertEquals(Opened::class, $incident->status::class);
    }

    public function test_unassigns_user_from_assigned_incidents()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create(['status' => Assigned::class, 'supervisor_id' => $user->id]);

        $event = new UserDeleted($user->id);

        $event->handle();

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);
    }

    public function test_gives_trashed_user_the_user_role()
    {
        $user = User::factory()->create();

        $event = new UserDeleted($user->id);

        $event->handle();

        $user->refresh();

        $this->assertTrue($user->hasExactRoles('user'));
    }

    public function test_deletes_user()
    {
        $user = User::factory()->create();

        $event = new UserDeleted($user->id);

        $event->handle();

        $user->refresh();

        $this->assertTrue($user->trashed());
    }
}
