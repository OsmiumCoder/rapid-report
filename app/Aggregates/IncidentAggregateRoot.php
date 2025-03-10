<?php

namespace App\Aggregates;

use App\Data\CommentData;
use App\Data\IncidentData;
use App\Enum\CommentType;
use App\Exceptions\UserNotSupervisorException;
use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\Reopened;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\Comment\CommentCreated;
use App\StorableEvents\Incident\AdditionalInformationAdded;
use App\StorableEvents\Incident\FileCreated;
use App\StorableEvents\Incident\FilesUploaded;
use App\StorableEvents\Incident\IncidentClosed;
use App\StorableEvents\Incident\IncidentCreated;
use App\StorableEvents\Incident\IncidentReopened;
use App\StorableEvents\Incident\IncidentReviewRequested;
use App\StorableEvents\Incident\SupervisorAssigned;
use App\StorableEvents\Incident\SupervisorUnassigned;
use App\StorableEvents\Investigation\InvestigationReturned;
use App\StorableEvents\RootCauseAnalysis\RootCauseAnalysisReturned;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\EventSourcing\AggregateRoots\AggregateRoot;


/**
 * Handles all events related to incidents.
 *
 * @see Incident The model that is being aggregated.
 */
class IncidentAggregateRoot extends AggregateRoot
{
    /**
     * Records an IncidentCreated event.
     *
     * @param IncidentData $incidentData The request data for the new incident.
     * @return $this
     * @see IncidentCreated The event recorded by this method.
     */
    public function createIncident(IncidentData $incidentData): static
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
     * Assigns the user of the given id to the aggregated incident.
     *
     * @param int $supervisorId Is user id of the supervisor to assign.
     * @return $this
     * @throws UserNotSupervisorException If the user for the given id is not a supervisor.
     * @see SupervisorAssigned The event recored by this method.
     */
    public function assignSupervisor(int $supervisorId): static
    {
        $user = User::find($supervisorId);

        if (! $user->hasRole('supervisor')) {
            throw UserNotSupervisorException::hasRoles($user->getRoleNames());
        }

        $this->recordThat(new SupervisorAssigned(supervisor_id: $supervisorId));

        return $this;
    }

    /**
     * Unassigns the current supervisor from the aggregated incident.
     *
     * @return $this
     * @see SupervisorUnassigned The event recorded by this method.
     */
    public function unassignSupervisor(): static
    {
        $this->recordThat(new SupervisorUnassigned);

        return $this;
    }

    /**
     * Transitions the aggregated incident to In Review status.
     *
     * @return $this
     * @see IncidentReviewRequested The event recorded by this method.
     */
    public function requestReview(): static
    {
        $this->recordThat(new IncidentReviewRequested);

        return $this;
    }

    /**
     * Transitions the aggregated incident to Returned status, for current investigation.
     *
     * @return $this
     * @see InvestigationReturned The event recorded by this method.
     * @see Returned The status the incident will transition to.
     */
    public function returnInvestigation(): static
    {
        $this->recordThat(new InvestigationReturned);

        return $this;
    }

    /**
     * Transitions the aggregated incident to Returned status, for current root cause analysis.
     *
     * @return $this
     * @see RootCauseAnalysisReturned The event recorded by this method.
     * @see Returned The status the incident will transition to.
     */
    public function returnRCA(): static
    {
        $this->recordThat(new RootCauseAnalysisReturned);

        return $this;
    }

    /**
     * Transitions the aggregated incident to Closed status.
     *
     * @return $this
     * @see IncidentClosed The event recorded by this method.
     * @see Closed The status the incident will transition to.
     */
    public function closeIncident(): static
    {
        $this->recordThat(new IncidentClosed);

        return $this;
    }

    /**
     * Transitions the aggregated incident to Reopened status.
     *
     * @return $this
     * @see IncidentReopened The event recorded by this method.
     * @see Reopened The status the incident will transition to.
     */
    public function reopenIncident(): static
    {
        $this->recordThat(new IncidentReopened);

        return $this;
    }

    /**
     * Attaches a comment to the aggregated incident.
     *
     * @param CommentData $commentData The request containing the comment to add.
     * @return $this
     * @see CommentCreated The event recorded by this method.
     */
    public function addComment(CommentData $commentData): static
    {
        $this->recordThat(new CommentCreated(
            content: $commentData->content,
            type: CommentType::NOTE,
            commentable_id: $this->uuid(),
            commentable_type: Incident::class
        ));

        return $this;
    }

    /**
     * Adds provided additional information to the aggregated incident.
     *
     * @param string $additionalInformation The additional information text to add to the incident.
     * @return $this
     */
    public function addAdditionalInformation(string $additionalInformation): static
    {
        $this->recordThat(new AdditionalInformationAdded($additionalInformation));

        return $this;
    }

    /**
     * Stores and attaches files to the aggregated incident.
     *
     * @param UploadedFile[] $files The list of uploaded files to store
     * @return $this
     * @see FileCreated Is recorded for every file that is stored.
     * @see FilesUploaded Is recorded when all files have been stored.
     */
    public function uploadFiles(array $files): static
    {
        foreach ($files as $file) {
            $storedFile = Storage::putFile($this->uuid(), $file);

            $this->recordThat(new FileCreated(
                name: $storedFile,
                original_name: $file->getClientOriginalName(),
                path: $this->uuid(),
                size: $file->getSize(),
                mime_type: $file->getMimeType(),
                extension: $file->extension(),
                fileable_id: $this->uuid(),
                fileable_type: Incident::class
            ));
        }

        $this->recordThat(new FilesUploaded);

        return $this;
    }
}
