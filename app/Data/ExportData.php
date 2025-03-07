<?php

namespace App\Data;

use Carbon\CarbonImmutable;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[MergeValidationRules]
class ExportData extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $start,
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $end,
        public array $fields
    ) {
        usort($this->fields, function ($a, $b) {
            $referenceArray = [
                'slug',
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

    public static function rules(ValidationContext $context): array
    {
        return [
            'fields' => ['min:1', 'distinct'],
            'fields.*' => [Rule::in([
                'slug',
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
