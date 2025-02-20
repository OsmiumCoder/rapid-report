<?php

namespace Tests\Feature\RootCauseAnalysis;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_assigned_supervisor_can_view_rca_create_form()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id, 'status' => Assigned::class]);

        $response = $this->get(route('incidents.root-cause-analyses.create', ['incident' => $incident->id]));

        $response->assertOk();

        $response->assertInertia(fn (AssertableInertia $page) =>
            $page->component('RootCauseAnalysis/Create')
                ->has('incident')
                ->where('incident.id', $incident->id));
    }

    public function test_unassigned_supervisor_can_not_view_rca_create_form()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.root-cause-analyses.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }

    public function test_user_can_not_view_rca_create_form()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.root-cause-analyses.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }

    public function test_admin_can_not_view_create_form()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $response = $this->get(route('incidents.root-cause-analyses.create', ['incident' => $incident->id]));

        $response->assertForbidden();
    }
}
