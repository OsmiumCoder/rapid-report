<?php

namespace App\StorableEvents\RootCauseAnalysis;

use App\Enum\CommentType;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use App\Notifications\RootCauseAnalysis\RootCauseAnalysisSubmitted;
use App\StorableEvents\StoredEvent;
use Illuminate\Support\Facades\Notification;

class RootCauseAnalysisCreated extends StoredEvent
{
    public function __construct(
        public string $incident_id,
        public array $individuals_involved,
        public string $primary_effect,
        public array $whys,
        public array $solutions_and_actions,
        public ?array $peoples_positions,
        public ?array $attention_to_work,
        public ?array $communication,
        public bool $ppe_in_good_condition,
        public bool $ppe_in_use,
        public bool $ppe_correct_type,
        public bool $correct_tool_used,
        public bool $policies_followed,
        public bool $worked_safely,
        public bool $used_tool_properly,
        public bool $tool_in_good_condition,
        public ?array $working_conditions,
        public array $root_causes,
    ) {
    }

    public function handle()
    {
        $incident = Incident::find($this->incident_id);

        $rca = new RootCauseAnalysis;

        $rca->id = $this->aggregateRootUuid();

        $rca->incident_id = $incident->id;
        $rca->supervisor_id = $this->metaData['user_id'];

        $rca->individuals_involved = $this->individuals_involved;
        $rca->primary_effect = $this->primary_effect;
        $rca->whys = $this->whys;
        $rca->solutions_and_actions = $this->solutions_and_actions;
        $rca->peoples_positions = $this->peoples_positions;
        $rca->attention_to_work = $this->attention_to_work;
        $rca->communication = $this->communication;
        $rca->ppe_in_good_condition = $this->ppe_in_good_condition;
        $rca->ppe_in_use = $this->ppe_in_use;
        $rca->ppe_correct_type = $this->ppe_correct_type;
        $rca->correct_tool_used = $this->correct_tool_used;
        $rca->policies_followed = $this->policies_followed;
        $rca->worked_safely = $this->worked_safely;
        $rca->used_tool_properly = $this->used_tool_properly;
        $rca->tool_in_good_condition = $this->tool_in_good_condition;
        $rca->working_conditions = $this->working_conditions;
        $rca->root_causes = $this->root_causes;

        $rca->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'];
        $comment->type = CommentType::ACTION;
        $comment->content = 'Root Cause Analysis was created.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        $admins = User::role('admin')->get();

        $supervisor = User::find($this->metaData['user_id']);

        Notification::send($admins, new RootCauseAnalysisSubmitted($this->incident_id, $this->aggregateRootUuid(), $supervisor));
    }
}
