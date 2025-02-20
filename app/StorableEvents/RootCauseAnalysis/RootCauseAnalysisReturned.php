<?php

namespace App\StorableEvents\RootCauseAnalysis;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\StoredEvent;

class RootCauseAnalysisReturned extends StoredEvent
{
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $incident->status->transitionTo(Returned::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident Root Cause Analysis was returned for re-review.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }
}
