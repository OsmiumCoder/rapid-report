<?php

namespace App\Data;

use App\Enum\IncidentType;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class IncidentData extends Data
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
        public bool $workers_comp,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $happened_at,
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
    ) {}
}
