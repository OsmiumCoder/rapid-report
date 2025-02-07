<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class InvestigationData extends Data
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
}
