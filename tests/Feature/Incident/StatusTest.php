<?php

namespace Tests\Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\InReview;
use App\States\IncidentStatus\Reopened;
use Tests\TestCase;

class StatusTest extends TestCase
{
    public function test_admin_can_reopen_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->put(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Reopened::class, $incident->status::class);
        $this->assertNull($incident->supervisor_id);
    }

    public function test_user_can_not_reopen_incidents()
    {
        $user = User::factory()->create()->assignRole('user');

        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->put(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_supervisor_can_not_reopen_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Closed::class,
        ]);

        $response = $this->put(route('incidents.reopen', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_admin_can_close_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($admin);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->put(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(302);

        $incident->refresh();

        $this->assertEquals(Closed::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_user_can_not_close_incidents()
    {
        $user = User::factory()->create()->assignRole('user');

        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($user);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->put(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(403);

        $incident->refresh();

        $this->assertEquals(InReview::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }

    public function test_supervisor_can_not_close_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class,
        ]);

        $response = $this->put(route('incidents.close', ['incident' => $incident]));

        $response->assertStatus(403);

        $this->assertEquals(InReview::class, $incident->status::class);
        $this->assertEquals($supervisor->id, $incident->supervisor->id);
    }
}
