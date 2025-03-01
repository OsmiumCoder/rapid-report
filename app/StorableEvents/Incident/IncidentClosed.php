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
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->status->transitionTo(Closed::class);
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
        $incident = Incident::find($this->aggregateRootUuid());

        if ($incident->supervisor) {
            Notification::send($incident->supervisor, new IncidentClosedNotification($incident->id));
        }

        $admins = User::role('admin')->get();
        Notification::send($admins, new IncidentClosedNotification($incident->id));
    }
}
