<?php

namespace App\Aggregates;

use App\Data\RootCauseAnalysisData;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 * Handles all events related to root cause analyses.
 *
 * @see RootCauseAnalysis The model that is being aggregated.
 */
class RootCauseAnalysisAggregateRoot extends AggregateRoot
{
    /**
     * Records an RootCauseAnalysisCreated event.
     *
     * @param RootCauseAnalysisData $investigationData The request data for the new root cause analysis.
     * @param Incident $incident The Incident in which to attach the root cause analysis to.
     * @return $this
     * @see RootCauseAnalysisCreated The event recorded by this method.
     */
    public function createRootCauseAnalysis(RootCauseAnalysisData $investigationData, Incident $incident): static
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
