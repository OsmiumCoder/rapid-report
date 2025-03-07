<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\StoredEvent;
use Spatie\ModelStates\Exceptions\CouldNotPerformTransition;

class SupervisorUnassigned extends StoredEvent
{
    /**
     * @throws CouldNotPerformTransition
     */
    public function handle(): void
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->supervisor_id = null;
        $incident->status->transitionTo(Opened::class);
        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was unassigned.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }
}
