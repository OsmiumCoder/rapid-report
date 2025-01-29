<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\States\IncidentStatus\Closed;
use App\StorableEvents\StoredEvent;

class IncidentClosed extends StoredEvent
{
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->status->transitionTo(Closed::class);
        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was closed.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }
}
