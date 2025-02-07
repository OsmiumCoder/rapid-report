<?php

namespace Feature\Investigation;

use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_admin_can_view_investigation_show_page()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.investigations.show', ['incident' => $incident->id, 'investigation'  => $investigation->id]));

        $response->assertOk();
    }

    public function test_supervisor_can_view_investigation_show_page_on_assigned_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.investigations.show', ['incident' => $incident->id, 'investigation'  => $investigation->id]));

        $response->assertOk();
    }

    public function test_supervisor_can_not_view_investigation_show_page_on_assigned_incident()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.investigations.show', ['incident' => $incident->id, 'investigation'  => $investigation->id]));

        $response->assertForbidden();
    }

    public function test_user_can_not_view_investigation_show_page()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.investigations.show', ['incident' => $incident->id, 'investigation'  => $investigation->id]));

        $response->assertForbidden();
    }

    public function test_show_investigation_page_loads_incident_on_investigation_prop()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.investigations.show', ['incident' => $incident->id, 'investigation'  => $investigation->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($incident) {
            $page->component('Investigation/Show')
                ->has('investigation')
                ->has('investigation.incident')
                ->where('investigation.incident.id', $incident->id);
        });
    }

    public function test_investigation_show_page_returns_correct_investigation_values()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $investigation = Investigation::factory()->create(['incident_id' => $incident->id, 'resulted_in' => ['Injury']]);

        $response = $this->get(route('incidents.investigations.show', ['incident' => $incident->id, 'investigation'  => $investigation->id]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($investigation) {
            $page->component('Investigation/Show')
                ->has('investigation')
                ->where('investigation.id', $investigation->id)
                ->where('investigation.incident_id', $investigation->incident_id)
                ->where('investigation.immediate_causes', $investigation->immediate_causes)
                ->where('investigation.basic_causes', $investigation->basic_causes)
                ->where('investigation.remedial_actions', $investigation->remedial_actions)
                ->where('investigation.prevention', $investigation->prevention)
                ->where('investigation.hazard_class', $investigation->hazard_class)
                ->where('investigation.risk_rank', $investigation->risk_rank)
                ->has('investigation.resulted_in', 1)
                ->where('investigation.resulted_in.0', 'Injury');
        });
    }
}
