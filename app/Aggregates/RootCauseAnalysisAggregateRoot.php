<?php

namespace App\Aggregates;

use App\Data\RootCauseAnalysisData;
use App\Models\Incident;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class RootCauseAnalysisAggregateRoot extends AggregateRoot
{
    public function createRootCauseAnalysis(RootCauseAnalysisData $investigationData, Incident $incident)
    {
        $this->recordThat(new RootCauseAnalysisCreated(
            incident_id: $incident->id,
            individuals_involved: $investigationData->individuals_involved,
            primary_effect: $investigationData->primary_effect,
            whys: $investigationData->whys,
            solutions_and_actions: $investigationData->solutions_and_actions,
            peoples_positions: $investigationData->peoples_positions,
            attention_to_work: $investigationData->attention_to_work,
            communication: $investigationData->communication,
            ppe_in_good_condition: $investigationData->ppe_in_good_condition,
            ppe_in_use: $investigationData->ppe_in_use,
            ppe_correct_type: $investigationData->ppe_correct_type,
            correct_tool_used: $investigationData->correct_tool_used,
            policies_followed: $investigationData->policies_followed,
            worked_safely: $investigationData->worked_safely,
            used_tool_properly: $investigationData->used_tool_properly,
            tool_in_good_condition: $investigationData->tool_in_good_condition,
            working_conditions: $investigationData->working_conditions,
            root_causes: $investigationData->root_causes,
        ));

        return $this;
    }
}
