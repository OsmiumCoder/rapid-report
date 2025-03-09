<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\IncidentReviewRequestNotification;
use App\States\IncidentStatus\InReview;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class IncidentReviewRequested extends StoredEvent
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

        $incident->status->transitionTo(InReview::class);

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident review was requested.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react(): void
    {
        $admins = User::role('admin')->get();
        $supervisor = User::find($this->metaData['user_id']);

        $incident = $this->incident();

        Notification::send($admins, new IncidentReviewRequestNotification($incident->slug, $supervisor));
    }
}
