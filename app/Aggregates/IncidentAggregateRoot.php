<?php

namespace App\Aggregates;

use App\Data\CommentData;
use App\Data\IncidentData;
use App\Enum\CommentType;
use App\Exceptions\UserNotSupervisorException;
use App\Models\Incident;
use App\Models\User;
use App\StorableEvents\Comment\CommentCreated;
use App\StorableEvents\Incident\IncidentClosed;
use App\StorableEvents\Incident\IncidentCreated;
use App\StorableEvents\Incident\IncidentReopened;
use App\StorableEvents\Incident\SupervisorAssigned;
use App\StorableEvents\Incident\SupervisorUnassigned;
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
            workers_comp_submitted: $incidentData->workers_comp_submitted,
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

    /**
     * @throws UserNotSupervisorException
     */
    public function assignSupervisor(int $supervisorId)
    {
        $user = User::find($supervisorId);

        if (! $user->hasRole('supervisor')) {
            throw UserNotSupervisorException::hasRoles($user->getRoleNames());
        }

        $this->recordThat(new SupervisorAssigned(supervisor_id: $supervisorId));

        return $this;
    }

    public function unassignSupervisor()
    {
        $this->recordThat(new SupervisorUnassigned);

        return $this;
    }

    public function closeIncident()
    {
        $this->recordThat(new IncidentClosed);

        return $this;
    }

    public function reopenIncident()
    {
        $this->recordThat(new IncidentReopened);

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
