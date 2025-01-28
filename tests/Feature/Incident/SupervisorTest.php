<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use Tests\TestCase;

class SupervisorTest extends TestCase
{
    public function test_unassign_supervisor_not_permitted_by_supervisor()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        $response = $this->put(route('incidents.unassign-supervisor', ['incident' => $incident->id]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals($supervisor->id, $incident->supervisor_id);
        $this->assertEquals(Assigned::class, $incident->status::class);
    }

    public function test_unassign_supervisor_not_permitted_by_user()
    {
        $user = User::factory()->create()->assignRole('user');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        $response = $this->put(route('incidents.unassign-supervisor', ['incident' => $incident->id]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertNotNull($incident->supervisor_id);
    }

    public function test_unassign_supervisor_removes_supervisor_id_from_incident()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class,
        ]);

        $response = $this->put(route('incidents.unassign-supervisor', ['incident' => $incident->id]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);
    }

    public function test_assign_supervisor_updates_supervisor_id_on_incident()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $this->assertNull($incident->supervisor_id);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals($supervisor->id, $incident->supervisor_id);
        $this->assertInstanceOf(User::class, $incident->supervisor);
    }

    public function test_assign_supervisor_not_permitted_by_user()
    {
        $user = User::factory()->create()->assignRole('user');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create();
        $this->assertNull($incident->supervisor_id);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);

    }

    public function test_assign_supervisor_not_permitted_by_supervisor()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();
        $this->assertNull($incident->supervisor_id);

        $response = $this->put(route('incidents.assign-supervisor', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertNull($incident->supervisor_id);

    }
}
