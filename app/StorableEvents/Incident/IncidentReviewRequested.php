<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentReviewRequest;
use App\States\IncidentStatus\InReview;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class IncidentReviewRequested extends StoredEvent
{
    public function __construct()
    {
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());

        $incident->status->transitionTo(InReview::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident review was requested.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        $admins = User::role('admin')->get();

        $supervisor = User::find($this->metaData['user_id']);

        Notification::send($admins, new IncidentReviewRequest($this->aggregateRootUuid(), $supervisor));
    }
}
