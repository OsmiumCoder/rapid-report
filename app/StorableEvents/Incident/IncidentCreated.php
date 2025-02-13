<?php

namespace App\StorableEvents\Incident;

use App\Enum\CommentType;
use App\Enum\IncidentType;
use App\Mail\IncidentReceived;
use App\Models\Comment;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\IncidentSubmitted;
use App\StorableEvents\StoredEvent;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class IncidentCreated extends StoredEvent
{
    public function __construct(
        public bool $anonymous,
        public bool $on_behalf,
        public bool $on_behalf_anonymous,
        public int $role,
        public ?string $last_name,
        public ?string $first_name,
        public ?string $upei_id,
        public ?string $email,
        public ?string $phone,
        public bool $work_related,
        public bool $workers_comp_submitted,
        public Carbon $happened_at,
        public ?string $location,
        public ?string $room_number,
        public ?array $witnesses,
        public IncidentType $incident_type,
        public string $descriptor,
        public ?string $description,
        public ?string $injury_description,
        public ?string $first_aid_description,
        public ?string $reporters_email,
        public ?string $supervisor_name,
    ) {
    }

    public function handle()
    {
        $incident = new Incident;

        $incident->id = $this->aggregateRootUuid();

        $incident->anonymous = $this->anonymous;
        $incident->on_behalf = $this->on_behalf;
        $incident->on_behalf_anonymous = $this->on_behalf_anonymous;

        $incident->role = $this->role;
        $incident->last_name = $this->last_name;
        $incident->first_name = $this->first_name;
        $incident->upei_id = $this->upei_id;
        $incident->email = $this->email;
        $incident->phone = $this->phone;
        $incident->work_related = $this->work_related;
        $incident->workers_comp_submitted = $this->workers_comp_submitted;
        $incident->happened_at = $this->happened_at;
        $incident->location = $this->location;
        $incident->room_number = $this->room_number;
        $incident->witnesses = $this->witnesses;
        $incident->incident_type = $this->incident_type;
        $incident->descriptor = $this->descriptor;
        $incident->description = $this->description;
        $incident->injury_description = $this->injury_description;
        $incident->first_aid_description = $this->first_aid_description;
        $incident->reporters_email = $this->reporters_email;
        $incident->supervisor_name = $this->supervisor_name;

        $incident->save();

        $comment = new Comment;

        $comment->user_id = $this->metaData['user_id'] ?? null;
        $comment->type = CommentType::ACTION;
        $comment->content = 'Incident was created.';

        $comment->commentable()->associate($incident);

        $comment->save();
    }

    public function react()
    {
        if ($this->reporters_email) {
            Mail::to($this->reporters_email)->send(new IncidentReceived);
        }

        $admins = User::role('admin')->get();
        Notification::send($admins, new IncidentSubmitted($this->aggregateRootUuid()));
    }
}
