<?php

namespace Feature\Incident;

use App\Models\Incident;
use App\Models\User;
use Sti3bas\ScoutArray\Facades\Search;
use Tests\TestCase;

class SearchTest extends TestCase
{
    public function test_admin_search_returns_correct_incidents()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $this->actingAs($admin);

        $incidentA = Incident::factory()->create(['description' => 'description a']);
        $incidentB = Incident::factory()->create(['description' => 'description b']);

        Search::fakeRecord($incidentA, [
            'description' => 'description a',
        ]);
        Search::fakeRecord($incidentB, [
            'description' => 'description b',
        ]);

        $response = $this->get(route('incidents.search', ['search' => 'description a', 'search_by' => 'description']));
        $response->assertStatus(200);

        $fetchedIncidents = $response->json();

        $this->assertCount(1, $fetchedIncidents);

        $this->assertEquals($incidentA->id, $fetchedIncidents[0]['id']);
    }

    public function test_supervisor_search_returns_assigned_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        $incidentA = Incident::factory()->create(['description' => 'description a', 'supervisor_id' => $supervisor->id]);
        $incidentB = Incident::factory()->create(['description' => 'description a']);

        Search::fakeRecord($incidentA, [
            'description' => 'description a',
        ]);
        Search::fakeRecord($incidentB, [
            'description' => 'description b',
        ]);

        $response = $this->get(route('incidents.search', ['search' => 'description a', 'search_by' => 'description']));
        $response->assertStatus(200);

        $fetchedIncidents = $response->json();

        $this->assertCount(1, $fetchedIncidents);

        $this->assertEquals($incidentA->id, $fetchedIncidents[0]['id']);
    }

    public function test_supervisor_search_does_not_return_unassigned_incidents()
    {
        $supervisor = User::factory()->create()->assignRole('supervisor');
        $this->actingAs($supervisor);

        $incidentA = Incident::factory()->create(['description' => 'description a']);
        $incidentB = Incident::factory()->create(['description' => 'description b']);

        Search::fakeRecord($incidentA, [
            'description' => 'description a',
        ]);
        Search::fakeRecord($incidentB, [
            'description' => 'description b',
        ]);

        $response = $this->get(route('incidents.search', ['search' => 'description a', 'search_by' => 'description']));
        $response->assertStatus(200);

        $fetchedIncidents = $response->json();

        $this->assertCount(0, $fetchedIncidents);
    }

    public function test_user_incident_search_throws_forbidden_exception()
    {
        $user = User::factory()->create()->assignRole('user');
        $this->actingAs($user);

        $response = $this->get(route('incidents.search', ['search' => 'description', 'search_by' => 'description']));
        $response->assertStatus(403);
    }
}
