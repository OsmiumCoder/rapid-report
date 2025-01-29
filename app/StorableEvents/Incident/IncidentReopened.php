<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\StoredEvent;

class IncidentReopened extends StoredEvent
{
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->status->transitionTo(Reopened::class);
        $incident->supervisor_id = null;
        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was reopened.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }
}
