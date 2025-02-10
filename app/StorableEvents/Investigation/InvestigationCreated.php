<?php

namespace App\StorableEvents\Investigation;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\Investigation;
use App\Models\User;
use App\Notifications\Investigation\InvestigationSubmitted;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class InvestigationCreated extends StoredEvent
{
    public function __construct(
        public string $incident_id,
        public string $immediate_causes,
        public string $basic_causes,
        public string $remedial_actions,
        public string $prevention,
        public string $hazard_class,
        public int $risk_rank,
        public array $resulted_in
    ) {
    }

    public function handle()
    {
        $investigation = new Investigation;

        $investigation->id = $this->aggregateRootUuid();

        $investigation->incident_id = $this->incident_id;
        $investigation->supervisor_id = $this->metaData['user_id'];
        $investigation->immediate_causes = $this->immediate_causes;
        $investigation->basic_causes = $this->basic_causes;
        $investigation->remedial_actions = $this->remedial_actions;
        $investigation->prevention = $this->prevention;
        $investigation->hazard_class = $this->hazard_class;
        $investigation->risk_rank = $this->risk_rank;
        $investigation->resulted_in = $this->resulted_in;

        $investigation->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Investigation was created.';

        $comment->commentable_id = $this->incident_id;
        $comment->commentable_type = Incident::class;

        $comment->save();
    }

    public function react()
    {
        $admins = User::role('admin')->get();

        $supervisor = User::find($this->metaData['user_id']);

        Notification::send($admins, new InvestigationSubmitted($this->aggregateRootUuid(), $supervisor));
    }
}
