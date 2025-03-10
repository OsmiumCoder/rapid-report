<?php

namespace App\Aggregates;

use App\Data\InvestigationData;
use App\Models\Incident;
use App\Models\Investigation;
use App\StorableEvents\Investigation\InvestigationCreated;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

/**
 * Handles all events related to investigations.
 *
 * @see Investigation The model that is being aggregated.
 */
class InvestigationAggregateRoot extends AggregateRoot
{
    /**
     * Records an InvestigationCreated event.
     *
     * @param InvestigationData $investigationData The request data for the new investigation.
     * @param Incident $incident The Incident in which to attach the Investigation to.
     * @return $this
     * @see InvestigationCreated The event recorded by this method.
     */
    public function createInvestigation(InvestigationData $investigationData, Incident $incident): static
    {
        $this->recordThat(new InvestigationCreated(
            incident_id: $incident->id,
            immediate_causes: $investigationData->immediate_causes,
            basic_causes: $investigationData->basic_causes,
            remedial_actions: $investigationData->remedial_actions,
            prevention: $investigationData->prevention,
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
