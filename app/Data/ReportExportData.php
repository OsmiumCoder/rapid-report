<?php

namespace App\Data;

use App\Enum\IncidentType;
use Carbon\Carbon;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class ReportExportData extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $timelineStart,
        #[WithCast(DateTimeInterfaceCast::class)]
        public ?Carbon $timelineEnd,
        public bool $work_related,
        public bool $workers_comp_submitted,
        public bool $location,
        public bool $room_number,
        public bool $incident_type,
        public bool $descriptor,
        public bool $description,
        public bool $injury_description,
        public bool $first_aid_description,
        public bool $closed_at,
        public bool $created_at,
        public bool $updated_at,
        public bool $deleted_at,
    ) {}
}
