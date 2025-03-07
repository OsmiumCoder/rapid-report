<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentClosedNotification;
use App\States\IncidentStatus\Closed;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class IncidentClosed extends StoredEvent
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
        $incident->status->transitionTo(Closed::class);
        $incident->closed_at = now();
        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was closed.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react(): void
    {
        $incident = $this->incident();

        if ($incident->supervisor) {
            Notification::send($incident->supervisor, new IncidentClosedNotification($incident->id));
        }

        $admins = User::role('admin')->get();
        Notification::send($admins, new IncidentClosedNotification($incident->slug));
    }
}
