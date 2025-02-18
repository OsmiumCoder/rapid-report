<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class InvestigationData extends Data
{
    public function __construct(
        public string $immediate_causes,
        public string $basic_causes,
        public string $remedial_actions,
        public string $prevention,
        public int $risk_rank,
        public array $resulted_in,
        public ?array $substandard_acts,
        public ?array $substandard_conditions,
        public ?array $energy_transfer_causes,
        public ?array $personal_factors,
        public ?array $job_factors,
    ) {
    }
}
