<?php

namespace App\Data;

use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

#[MergeValidationRules]
class RootCauseAnalysisData extends Data
{
    public function __construct(
        public array $individuals_involved,
        public string $primary_effect,
        public array $whys,
        public array $solutions_and_actions,
        public ?array $peoples_positions,
        public ?array $attention_to_work,
        public ?array $communication,
        public bool $ppe_in_good_condition,
        public bool $ppe_in_use,
        public bool $ppe_correct_type,
        public bool $correct_tool_used,
        public bool $policies_followed,
        public bool $worked_safely,
        public bool $used_tool_properly,
        public bool $tool_in_good_condition,
        public ?array $working_conditions,
        public array $root_causes,
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'individuals_involved.*.name' => ['required', 'string'],
            'individuals_involved.*.email' => ['sometimes', 'nullable', 'email'],
            'individuals_involved.*.phone' => ['sometimes', 'nullable', 'string'],

            'whys' => ['min:1', 'max:5'],
            'whys.0' => ['required', 'string'],
            'whys.*' => ['nullable', 'string'],

            'solutions_and_actions' => ['min:1', 'max:3'],
            'solutions_and_actions.*.cause' => ['required', 'string'],
            'solutions_and_actions.*.control' => ['required', 'string'],
            'solutions_and_actions.*.remedial_action' => ['required', 'string'],
            'solutions_and_actions.*.by_who' => ['required', 'string'],
            'solutions_and_actions.*.by_when' => ['required', Rule::date()->format('Y-m-d')],
            'solutions_and_actions.*.manager' => ['required', 'string'],

            'peoples_positions.*' => ['string'],
            'attention_to_work.*' => ['string'],
            'communication.*' => ['string'],
            'working_conditions.*' => ['string'],
            'root_causes.*' => ['string'],
        ];
    }
}
