<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentReopenedNotification;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class IncidentReopened extends StoredEvent
{
    private ?Incident $incident = null;

    public function incident(): Incident
    {
        if (!$this->incident) {
            $this->incident = Incident::find($this->aggregateRootUuid());
        }

        return $this->incident;
    }

    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(): void
    {
        $incident = $this->incident();
        $incident->status->transitionTo(Reopened::class);
        $incident->supervisor_id = null;
        $incident->closed_at = null;
        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was reopened.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react(): void
    {
        $incident = $this->incident();
        $admins = User::role('admin')->get();
        Notification::send($admins, new IncidentReopenedNotification($incident->slug));
    }
}
