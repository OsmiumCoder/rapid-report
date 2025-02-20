<?php

namespace App\StorableEvents\RootCauseAnalysis;

use App\Enum\CommentType;
use App\States\IncidentStatus\Returned;

class RootCauseAnalysisReturned
{
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $incident->status->transitionTo(Returned::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->type = CommentType::ACTION;
        $comment->content = 'Root Cause Analysis was returned for re-investigation.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }
}
