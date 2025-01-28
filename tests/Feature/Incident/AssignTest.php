<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use Tests\TestCase;

class AssignTest extends TestCase
{
    public function test_assign_supervisor_updates_supervisor_id()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $this->assertDatabaseCount('incidents', 0);

        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('incidents', 1);

        $response = $this->put(route('incidents.assign', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(200);

        $updated_incident = Incident::first();

        $this->assertEquals($supervisor->id, $updated_incident->supervisor_id);
    }

    public function test_assign_supervisor_not_permitted_by_user()
    {
        $user = User::factory()->create()->assignRole('user');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($user);

        $this->assertDatabaseCount('incidents', 0);

        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('incidents', 1);

        $response = $this->put(route('incidents.assign', ['incident' => $incident->id]), ['supervisor_id' => $supervisor->id]);

        $response->assertStatus(403);

    }
}
