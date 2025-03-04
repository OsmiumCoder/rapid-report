<?php

namespace App\StorableEvents\RootCauseAnalysis;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\RootCauseAnalysis\RootCauseAnalysisReturnedNotification;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class RootCauseAnalysisReturned extends StoredEvent
{
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $incident->status->transitionTo(Returned::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident Root Cause Analysis was returned for re-review.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $supervisor = $incident->supervisor;

        if ($supervisor) {
            Notification::send($supervisor, new RootCauseAnalysisReturnedNotification($incident->slug, $this->aggregateRootUuid()));
        }

        $admins = User::role('admin')->get();
        Notification::send($admins, new RootCauseAnalysisReturnedNotification($incident->slug, $this->aggregateRootUuid()));
    }
}
