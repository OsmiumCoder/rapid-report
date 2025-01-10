<?php

namespace App\Data;

use App\Models\User;
use Carbon\Carbon;
use Spatie\LaravelData\Data;

class IncidentData extends Data
{
    public int $id;

    public int $user_id;

    public int $supervisor_id;

    /** @var User[] */
    public array $witnesses;

    public bool $work_related = false;

    public Carbon $incident_date;

    public string $location;

    public string $room_number;

    public string $reported_to;

    public string $incident_type;

    public string $descriptor;

    public string $description;

    public bool $has_injury;

    public string $first_aid_description;

    public bool $completed = false;

    public Carbon $closing_date;

    public function __construct(
        int $id, int $user_id, int $supervisor_id, bool $work_related,
        Carbon $closing_date, string $location, string $room_number,
        string $reported_to, string $incident_type, string $descriptor, array $witnesses,
        string $description, bool $has_injury, string $first_aid_description, bool $completed, Carbon $incident_date
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->supervisor_id = $supervisor_id;
        $this->work_related = $work_related;
        $this->closing_date = $closing_date;
        $this->location = $location;
        $this->room_number = $room_number;
        $this->reported_to = $reported_to;
        $this->incident_type = $incident_type;
        $this->descriptor = $descriptor;
        $this->description = $description;
        $this->has_injury = $has_injury;
        $this->first_aid_description = $first_aid_description;
        $this->completed = $completed;
        $this->incident_date = $incident_date;
        $this->witnesses = $witnesses;
    }
}
