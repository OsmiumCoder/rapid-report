<?php

namespace App\Data;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class IncidentData extends Data
{
    public function __construct(
        public int $role,
        public ?string $last_name,
        public ?string $first_name,
        public ?string $upei_id,
        public ?string $email,
        public ?string $phone,
        public bool $work_related,
        public Carbon $happened_at,
        public string $location,
        public ?string $room_number,
        public ?string $reported_to,
        public ?array $witnesses,
        public int $incident_type,
        public string $descriptor,
        public string $description,
        public ?string $injury_description,
        public ?string $first_aid_description,
        public ?string $reporters_email,
        public ?string $supervisor_name,
    ) {
    }
}
