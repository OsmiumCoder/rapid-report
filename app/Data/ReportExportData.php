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
        public string $timeline_start,
        public string $timeline_end,
        public bool $happened_at = false,
        public bool    $work_related = false,
        public bool    $personal_individual_information = false,
        public bool    $workers_comp_submitted = false ,
        public bool    $location = false,
        public bool    $room_number = false,
        public bool    $incident_type = false,
        public bool    $descriptor = false,
        public bool    $description = false,
        public bool    $injury_description = false,
        public bool    $first_aid_description = false,
        public bool    $closed_at = false,
        public bool $created_at = false,
        public bool $updated_at = false,
        public bool $deleted_at = false,
    ) {}
}
