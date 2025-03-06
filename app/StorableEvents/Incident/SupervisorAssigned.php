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

class SupervisorAssigned extends StoredEvent
{
    private User $supervisor;

    public function __construct(
        public int $supervisor_id,
    ) {
    }

    public function supervisor()
    {
        if (!$this->supervisor) {
            $this->supervisor = User::find($this->supervisor_id);
        }

        return $this->supervisor;
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

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

    public function react()
    {
        $admin = User::find($this->metaData['user_id']);
        $incident = Incident::find($this->aggregateRootUuid());

        Notification::send($this->supervisor(), new SupervisorAssignedNotification($incident->slug, $this->supervisor(), $admin));

        Notification::send($this->supervisor(), new IncidentFollowUpOverdueNotification($incident->slug, $this->supervisor()));
    }
}
