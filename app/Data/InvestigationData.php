<?php

namespace App\Data;

use App\Models\Investigation;
use Spatie\LaravelData\Data;

/**
 * Request data for creation of an investigation.
 *
 * @see Investigation The model that will be created for this data.
 */
class InvestigationData extends Data
{
    /**
     * @param string|null $immediate_causes Optional. The immediate causes the supervisor attributed the incident to.
     * @param string|null $basic_causes Optional. The basic causes the supervisor attributed the incident to.
     * @param string $remedial_actions The remedial actions the supervisor took to deal with the incident.
     * @param string|null $prevention Optional. The preventive measures that were taken as a result of the incident.
     * @param int $risk_rank The Risk Ranking that was determined for the situation.
     * @param array $resulted_in The result of the incident occurring and how it affected all parties.
     * @param array|null $substandard_acts Optional. Factors deemed as substandard acts that contributed to the incident.
     * @param array|null $substandard_conditions Optional. Factors deemed as substandard conditions that contributed to the incident.
     * @param array|null $energy_transfer_causes Optional. Physical exertion factors that contributed to the incident.
     * @param array|null $personal_factors Optional. Factors related to the individuals state that contributed to the incident.
     * @param array|null $job_factors Optional. Factors related to the workplace environment that contributed to the incident.
     */
    public function __construct(
        public ?string $immediate_causes,
        public ?string $basic_causes,
        public string $remedial_actions,
        public ?string $prevention,
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
