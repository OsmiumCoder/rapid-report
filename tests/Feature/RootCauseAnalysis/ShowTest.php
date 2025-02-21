<?php

namespace Tests\Feature\RootCauseAnalysis;

use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function test_admin_can_view_rca_show_page()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $rca = RootCauseAnalysis::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.root-cause-analyses.show', [
            'incident' => $incident->id,
            'root_cause_analysis'  => $rca->id
        ]));

        $response->assertOk();
    }

    public function test_supervisor_can_view_rca_show_page_if_they_made_rca()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create(['supervisor_id' => $supervisor->id]);
        $rca = RootCauseAnalysis::factory()->create(['supervisor_id' => $supervisor->id]);

        $response = $this->get(route('incidents.root-cause-analyses.show', [
            'incident' => $incident->id,
            'root_cause_analysis' => $rca->id
        ]));

        $response->assertOk();
    }

    public function test_supervisor_can_not_view_rca_show_page_if_they_did_not_make_rca()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();
        $rca = RootCauseAnalysis::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.root-cause-analyses.show', [
            'incident' => $incident->id,
            'root_cause_analysis' => $rca->id
        ]));

        $response->assertForbidden();
    }

    public function test_user_can_not_view_rca_show_page()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create();
        $rca = RootCauseAnalysis::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.root-cause-analyses.show', [
            'incident' => $incident->id,
            'root_cause_analysis'  => $rca->id
        ]));

        $response->assertForbidden();
    }

    public function test_show_rca_page_loads_incident_on_rca_prop()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();
        $rca = RootCauseAnalysis::factory()->create(['incident_id' => $incident->id]);

        $response = $this->get(route('incidents.root-cause-analyses.show', [
                'incident' => $incident->id,
                'root_cause_analysis'  => $rca->id
            ]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($incident) {
            $page->component('RootCauseAnalysis/Show')
                ->has('rca')
                ->has('rca.incident')
                ->where('rca.incident.id', $incident->id);
        });
    }

    public function test_rca_show_page_returns_correct_rca_values()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $incident = Incident::factory()->create();
        $rca = RootCauseAnalysis::factory()->create([
            'incident_id' => $incident->id,
            'supervisor_id' => $supervisor->id,
            'whys' => ['why 1'],
            'individuals_involved' => ['individual'],
            'primary_effect' => 'primary',
            'solutions_and_actions' => ['solution'],
            'peoples_positions' => ['people'],
            'attention_to_work' => ['attention'],
            'communication' => ['communication'],
            'ppe_in_good_condition' => true,
            'ppe_in_use' => true,
            'ppe_correct_type' => true,
            'correct_tool_used' => true,
            'policies_followed' => true,
            'worked_safely' => true,
            'used_tool_properly' => true,
            'tool_in_good_condition' => true,
            'working_conditions' => ['working'],
            'root_causes' => ['root_cause'],
        ]);

        $response = $this->get(route('incidents.root-cause-analyses.show', [
            'incident' => $incident->id,
            'root_cause_analysis'  => $rca->id
        ]));

        $response->assertOk();

        $response->assertInertia(function (AssertableInertia $page) use ($rca) {
            $page->component('RootCauseAnalysis/Show')
                ->has('rca')
                ->where('rca.id', $rca->id)
                ->where('rca.incident.id', $rca->incident_id)
                ->where('rca.supervisor.id', $rca->supervisor_id)
                ->where('rca.whys', $rca->whys)
                ->where('rca.individuals_involved', $rca->individuals_involved)
                ->where('rca.primary_effect', $rca->primary_effect)
                ->where('rca.solutions_and_actions', $rca->solutions_and_actions)
                ->where('rca.peoples_positions', $rca->peoples_positions)
                ->where('rca.attention_to_work', $rca->attention_to_work)
                ->where('rca.communication', $rca->communication)
                ->where('rca.ppe_in_good_condition', $rca->ppe_in_good_condition)
                ->where('rca.ppe_in_use', $rca->ppe_in_use)
                ->where('rca.ppe_correct_type', $rca->ppe_correct_type)
                ->where('rca.policies_followed', $rca->policies_followed)
                ->where('rca.worked_safely', $rca->worked_safely)
                ->where('rca.used_tool_properly', $rca->used_tool_properly)
                ->where('rca.tool_in_good_condition', $rca->tool_in_good_condition)
                ->where('rca.working_conditions', $rca->working_conditions)
                ->where('rca.worked_safely', $rca->worked_safely)
                ->where('rca.tool_in_good_condition', $rca->tool_in_good_condition);
            ;
        });
    }
}
