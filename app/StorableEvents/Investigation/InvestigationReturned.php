<?php

namespace App\StorableEvents\Investigation;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\States\IncidentStatus\Returned;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;
use App\Notifications\Investigation\InvestigationReturnedNotification;

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

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was returned for re-investigation.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        $admin = User::find($this->metaData['user_id']);
        $incident = Incident::find($this->aggregateRootUuid());
        $investigation = Investigation::where('incident_id', $this->aggregateRootUuid())->first();

        Notification::send($investigation->supervisor, new InvestigationReturnedNotification($incident->slug, $investigation->id, $admin));
    }
}
