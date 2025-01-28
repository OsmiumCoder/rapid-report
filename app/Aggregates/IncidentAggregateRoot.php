<?php

namespace App\Aggregates;

use App\Data\CommentData;
use App\Data\IncidentData;
use App\Enum\CommentType;
use App\Models\Incident;
use App\StorableEvents\Comment\CommentCreated;
use App\StorableEvents\Incident\IncidentCreated;
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

    public function addComment(CommentData $commentData)
    {
        $this->recordThat(new CommentCreated(
            content: $commentData->content,
            type: CommentType::NOTE,
            commentable_id: $this->uuid(),
            commentable_type: Incident::class
        ));

        return $this;
    }
}
