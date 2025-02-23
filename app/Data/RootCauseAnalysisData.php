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
        public ?array $individuals_involved,
        public ?string $primary_effect,
        public ?array $whys,
        public ?array $solutions_and_actions,
        public ?array $peoples_positions,
        public ?array $attention_to_work,
        public ?array $communication,
        public ?bool $ppe_in_good_condition,
        public ?bool $ppe_in_use,
        public ?bool $ppe_correct_type,
        public ?bool $correct_tool_used,
        public ?bool $policies_followed,
        public ?bool $worked_safely,
        public ?bool $used_tool_properly,
        public ?bool $tool_in_good_condition,
        public ?array $working_conditions,
        public ?array $root_causes,
    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'individuals_involved.*.name' => ['sometimes', 'nullable', 'string'],
            'individuals_involved.*.email' => ['sometimes', 'nullable', 'email'],
            'individuals_involved.*.phone' => ['sometimes', 'nullable', 'string'],

            'whys' => ['max:5'],
            'whys.*' => ['nullable', 'string'],

            'solutions_and_actions.*.cause' => ['sometimes', 'nullable', 'string'],
            'solutions_and_actions.*.control' => ['sometimes', 'nullable', 'string'],
            'solutions_and_actions.*.remedial_action' => ['sometimes', 'nullable', 'string'],
            'solutions_and_actions.*.by_who' => ['sometimes', 'nullable', 'string'],
            'solutions_and_actions.*.by_when' => ['sometimes', 'nullable', Rule::date()->format('Y-m-d')],

            'peoples_positions.*' => ['string'],
            'attention_to_work.*' => ['string'],
            'communication.*' => ['string'],
            'working_conditions.*' => ['string'],
            'root_causes.*' => ['string'],
        ];
    }

    public static function messages(): array
    {
        return [
            'individuals_involved.*.name.string' => 'Invalid name.',

            'individuals_involved.*.email.email' => 'Invalid email address.',

            'individuals_involved.*.phone.string' => 'Invalid Phone',

            'whys.*.string' => 'Invalid Why.',

            'solutions_and_actions.*.cause.required' => 'Cause is required.',
            'solutions_and_actions.*.cause.string' => 'Invalid Cause.',

            'solutions_and_actions.*.control.required' => 'Control is required.',
            'solutions_and_actions.*.control.string' => 'Invalid Control.',

            'solutions_and_actions.*.remedial_action.required' => 'Remedial action is required.',
            'solutions_and_actions.*.remedial_action.string' => 'Invalid Remedial Action.',

            'solutions_and_actions.*.by_who.required' => 'By who is required.',
            'solutions_and_actions.*.by_who.string' => 'Invalid By Who.',

            'solutions_and_actions.*.by_when.required' => 'By when is required.',
            'solutions_and_actions.*.by_when.string' => 'Invalid By When.',
        ];
    }
}
