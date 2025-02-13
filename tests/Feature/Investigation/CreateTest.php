<?php

namespace Tests\Feature\Investigation;

use App\Models\Incident;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\InReview;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;
use App\Models\User;

class CreateTest extends TestCase
{
    public function test_forbidden_if_not_assigned_state(): void
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => InReview::class
        ]);

        $response = $this->actingAs($supervisor)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }

    public function test_shows_create_page_and_has_incident(): void
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $response = $this->actingAs($supervisor)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertStatus(200);

        $response->assertInertia(function (AssertableInertia $page) use ($incident) {
            return $page->component('Investigation/Create')
                ->where('incident.id', $incident->id);
        });
    }

    public function test_forbidden_if_basic_user(): void
    {
        $incident = Incident::factory()->create();

        $user = User::factory()->create()->assignRole('user');

        $response = $this->actingAs($user)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }

    public function test_forbidden_if_admin(): void
    {
        $incident = Incident::factory()->create();

        $admin = User::factory()->create()->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('incidents.investigations.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }
}
