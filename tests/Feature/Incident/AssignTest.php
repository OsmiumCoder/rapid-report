<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use Tests\TestCase;
use function PHPUnit\Framework\assertEquals;

class AssignTest extends TestCase
{
    public function test_assign_supervisor_endpoint() {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $this->assertDatabaseCount('incidents', 0);

        $incident = Incident::factory()->create();

        $this->assertDatabaseCount('incidents', 1);

        $response = $this->put(route('incidents.assign', ['incident_id' => $incident->id, 'supervisor_id' => $supervisor->id]));

        $response->assertStatus(200);

        $updated_incident = Incident::first();

        assertEquals($supervisor->id, $updated_incident->supervisor_id);

    }


}
