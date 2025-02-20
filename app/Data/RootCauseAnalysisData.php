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

    public static function messages(): array
    {
        return [
            'individuals_involved.*.name.required' => 'Name is required.',
            'individuals_involved.*.name.string' => 'Invalid name.',

            'individuals_involved.*.email.email' => 'Invalid email address.',

            'individuals_involved.*.phone.string' => 'Phone is required.',

            'whys.*.required' => 'At least one Why is required.',
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

            'solutions_and_actions.*.manager.required' => 'Manager Name is required.',
            'solutions_and_actions.*.manager.string' => 'Invalid Manager.',

            'ppe_in_good_condition.boolean' => 'PPE In Good Condition is required.',
            'ppe_in_use.boolean' => 'PPE In Use is required.',
            'ppe_correct_type.boolean' => 'PPE Correct Type is required.',
            'correct_tool_used.boolean' => 'Correct Tool Used is required.',
            'policies_followed.boolean' => 'Policies Followed is required.',
            'worked_safely.boolean' => 'Worked Safely is required.',
            'used_tool_properly.boolean' => 'Used Tool Properly is required.',
            'tool_in_good_condition.boolean' => 'Tool In Good Condition is required.',
        ];
    }
}
