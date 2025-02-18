<?php

namespace Models;

use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use Tests\TestCase;

class RootCauseAnalysisTest extends TestCase
{
    public function test_rca_belongs_to_supervisor_relation()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $rca = RootCauseAnalysis::factory()->create(['supervisor_id' => $supervisor->id]);

        $this->assertEquals($supervisor->id, $rca->supervisor->id);
    }

    public function test_rca_belongs_to_incident_relation()
    {
        $incident = Incident::factory()->create();
        $rca = RootCauseAnalysis::factory()->create(['incident_id' => $incident->id]);

        $this->assertEquals($incident->id, $rca->incident->id);
    }

    public function test_creates_an_rca_model_with_valid_attributes()
    {
        $rca = RootCauseAnalysis::factory()->create();

        $this->assertNotNull($rca->supervisor_id);
        $this->assertNotNull($rca->incident_id);
        $this->assertNotNull($rca->individuals_involved);
        $this->assertNotNull($rca->primary_effect);
        $this->assertNotNull($rca->whys);
        $this->assertNotNull($rca->solutions_and_actions);
        $this->assertNotNull($rca->peoples_positions);
        $this->assertNotNull($rca->attention_to_work);
        $this->assertNotNull($rca->communication);
        $this->assertNotNull($rca->ppe_in_good_condition);
        $this->assertNotNull($rca->ppe_in_use);
        $this->assertNotNull($rca->ppe_correct_type);
        $this->assertNotNull($rca->correct_tool_used);
        $this->assertNotNull($rca->policies_followed);
        $this->assertNotNull($rca->worked_safely);
        $this->assertNotNull($rca->used_tool_properly);
        $this->assertNotNull($rca->tool_in_good_condition);
        $this->assertNotNull($rca->working_conditions);
        $this->assertNotNull($rca->root_causes);
    }
}
