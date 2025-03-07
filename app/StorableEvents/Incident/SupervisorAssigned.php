<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentFollowUpOverdueNotification;
use App\Notifications\Incident\SupervisorAssignedNotification;
use App\States\IncidentStatus\Assigned;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class SupervisorAssigned extends StoredEvent
{
    private ?Incident $incident = null;
    private ?User $supervisor = null;

    public function __construct(
        public int $supervisor_id,
    ) {
    }

    public function incident(): Incident
    {
        if (!$this->incident) {
            $this->incident = Incident::find($this->aggregateRootUuid());
        }

        return $this->incident;
    }

    public function supervisor(): User
    {
        if (!$this->supervisor) {
            $this->supervisor = User::find($this->supervisor_id);
        }

        return $this->supervisor;
    }

    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(): void
    {
        $incident = $this->incident();

        $incident->supervisor_id = $this->supervisor_id;
        $incident->status->transitionTo(Assigned::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was assigned to supervisor: ' . $this->supervisor()->name;

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react(): void
    {
        $admin = User::find($this->metaData['user_id']);
        $incident = $this->incident();

        Notification::send($this->supervisor(), new SupervisorAssignedNotification($incident->slug, $this->supervisor(), $admin));

        Notification::send($this->supervisor(), new IncidentFollowUpOverdueNotification($incident->slug, $this->supervisor()));
    }
}
