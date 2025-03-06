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

class IncidentClosed extends StoredEvent
{
    private ?Incident $incident = null;

    public function incident()
    {
        if (!$this->incident) {
            $this->incident = Incident::find($this->aggregateRootUuid());
        }

        return $this->incident;
    }

    public function handle()
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

    public function react()
    {
        $incident = $this->incident();

        if ($incident->supervisor) {
            Notification::send($incident->supervisor, new IncidentClosedNotification($incident->id));
        }

        $admins = User::role('admin')->get();
        Notification::send($admins, new IncidentClosedNotification($incident->slug));
    }
}
