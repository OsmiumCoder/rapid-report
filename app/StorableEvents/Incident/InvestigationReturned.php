<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\StoredEvent;

class InvestigationReturned extends StoredEvent
{
    public function __construct()
    {
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $incident->status->transitionTo(Returned::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was returned for re-investigation.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }
}
