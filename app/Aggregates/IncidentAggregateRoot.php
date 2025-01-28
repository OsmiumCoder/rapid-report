<?php

namespace App\Aggregates;

use App\Data\IncidentData;
use App\StorableEvents\Incident\IncidentCreated;
use App\StorableEvents\Incident\SupervisorAssigned;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;

class IncidentAggregateRoot extends AggregateRoot
{
    public function createIncident(IncidentData $incidentData)
    {
        $this->recordThat(new IncidentCreated(
            anonymous: $incidentData->anonymous,
            on_behalf: $incidentData->on_behalf,
            on_behalf_anonymous: $incidentData->on_behalf_anonymous,
            role: $incidentData->role,
            last_name: $incidentData->last_name,
            first_name: $incidentData->first_name,
            upei_id: $incidentData->upei_id,
            email: $incidentData->email,
            phone: $incidentData->phone,
            work_related: $incidentData->work_related,
            happened_at: $incidentData->happened_at,
            location: $incidentData->location,
            room_number: $incidentData->room_number,
            witnesses: $incidentData->witnesses,
            incident_type: $incidentData->incident_type,
            descriptor: $incidentData->descriptor,
            description: $incidentData->description,
            injury_description: $incidentData->injury_description,
            first_aid_description: $incidentData->first_aid_description,
            reporters_email: $incidentData->reporters_email,
            supervisor_name: $incidentData->supervisor_name,
        ));

        return $this;
    }

    public function assignSupervisor(int $supervisorId)
    {
        $this->recordThat(new SupervisorAssigned(supervisor_id: $supervisorId));
        return $this;
    }
}
