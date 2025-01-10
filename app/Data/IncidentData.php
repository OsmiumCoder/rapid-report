<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class IncidentData extends Data
{
    public function __construct(
        public int $user_id,
        public int $supervisor_id,
        public string $location,
        public string $room_number,
        public string $reported_to,
        public string $incident_type,
        public string $descriptor,
        public array $witnesses,
        public string $description,
        public bool $has_injury,
        public string $first_aid_description,
        public Carbon $incident_date,
        public bool $work_related = false,
    ) {}
}
