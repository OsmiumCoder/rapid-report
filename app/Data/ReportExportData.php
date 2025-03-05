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
class ReportExportData extends Data
{
    public function __construct(
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $start,
        #[WithCast(DateTimeInterfaceCast::class)]
        public CarbonImmutable $end,
        public array $fields
    ) {
        //        slug
        //        happened_at
        //        location
        //        room_number
        //        incident_type
        //        descriptor
        //        description
        //        injury_description
        //        first_aid_description
        //        created_at
        //        status
        //        closed_at

        //        anonymous
        //        on_behalf
        //        on_behalf_anonymous
        //        role
        //        work_related
        //        workers_comp_submitted

        //        last_name
        //        first_name
        //        upei_id
        //        email
        //        phone
        //        witnesses
        //        reporters_email
        //        supervisor_name

        //        additional_information
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'fields' => ['min:1', 'distinct'],
            'fields.*' => [Rule::in([
                'slug',
                'happened_at',
                'location',
                'room_number',
                'incident_type',
                'descriptor',
                'description',
                'injury_description',
                'first_aid_description',
                'created_at',
                'status',
                'closed_at',
            ])],
        ];
    }
}
