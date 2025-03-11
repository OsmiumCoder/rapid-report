<?php

namespace App\Data;

use App\Models\Incident;
use Carbon\CarbonImmutable;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

/**
 * Request data for incident export criteria.
 *
 * Rules method is overridden, and custom rules are merged with existing, inferred, rules.
 */
#[MergeValidationRules]
class IncidentExportData extends Data
{
    /**
     * @param CarbonImmutable $start The start date to export data for.
     * @param CarbonImmutable $end The end date to export data for.
     * @param string[] $fields The fields of the incident model to be exported.
     * @see Incident For a list of the incident fields.
     */
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $start,
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $end,
        public array $fields
    ) {
        usort($this->fields, function ($a, $b) {
            $referenceArray = [
                'ID',
                'anonymous',
                'on_behalf',
                'on_behalf_anonymous',
                'role',
                'last_name',
                'first_name',
                'upei_id',
                'email',
                'phone',
                'work_related',
                'workers_comp_submitted',
                'happened_at',
                'location',
                'room_number',
                'witnesses',
                'incident_type',
                'descriptor',
                'description',
                'injury_description',
                'first_aid_description',
                'reporters_email',
                'supervisor_name',
                'status',
                'additional_information',
                'closed_at',
                'created_at',
            ];
            $posA = array_search($a, $referenceArray);
            $posB = array_search($b, $referenceArray);
            return $posA - $posB;
        });

    }

    /**
     * Provides the validation rules for the request.
     *
     * $fields property must contain at least one element, and all elements must be distinct.
     * In addition, all elements of the array must be a valid incident field.
     *
     * @return array<string, array> The custom validation rules for request data.
     */
    public static function rules(): array
    {
        return [
            'fields' => ['min:1', 'distinct'],
            'fields.*' => [Rule::in([
                'ID',
                'anonymous',
                'on_behalf',
                'on_behalf_anonymous',
                'role',
                'last_name',
                'first_name',
                'upei_id',
                'email',
                'phone',
                'work_related',
                'workers_comp_submitted',
                'happened_at',
                'location',
                'room_number',
                'witnesses',
                'incident_type',
                'descriptor',
                'description',
                'injury_description',
                'first_aid_description',
                'reporters_email',
                'supervisor_name',
                'status',
                'additional_information',
                'closed_at',
                'created_at',
            ])],
        ];
    }
}
