<?php

namespace App\Aggregates;

use App\Data\InvestigationData;
use App\Models\Incident;
use App\StorableEvents\Investigation\InvestigationCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class InvestigationAggregateRoot extends AggregateRoot
{
    public function createInvestigation(InvestigationData $investigationData, Incident $incident)
    {
        $this->recordThat(new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: $investigationData->immediate_causes,
            basic_causes: $investigationData->basic_causes,
            remedial_actions: $investigationData->remedial_actions,
            prevention: $investigationData->prevention,
            hazard_class: $investigationData->hazard_class,
            risk_rank: $investigationData->risk_rank,
            resulted_in: $investigationData->resulted_in,
            substandard_acts: $investigationData->substandard_acts,
            substandard_conditions: $investigationData->substandard_conditions,
            energy_transfer_causes: $investigationData->energy_transfer_causes,
            personal_factors: $investigationData->personal_factors,
            job_factors: $investigationData->job_factors,
        ));

        return $this;
    }
}
