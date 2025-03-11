<?php

namespace App\Data;

use App\Models\RootCauseAnalysis;
use Illuminate\Validation\Rule;
use Spatie\LaravelData\Attributes\MergeValidationRules;
use Spatie\LaravelData\Data;

/**
 * Request data for creation of a root cause analysis.
 *
 * Rules method is overridden, and custom rules are merged with existing, inferred, rules.
 * All properties of this data is optional.
 *
 * @see RootCauseAnalysis The model that will be created for this data.
 */
#[MergeValidationRules]
class RootCauseAnalysisData extends Data
{
    /**
     * @param array<int, array<string, string>>|null $individuals_involved A list of the individuals that were deemed involved in the incident.
     * @param string|null $primary_effect The primary effect that caused the incident.
     * @param string[]|null $whys A list of the reasons why the incident likely occurred.
     * @param array<int, array<string, string>>|null $solutions_and_actions A list of the solutions and corrective actions taken by the supervisor.
     * @param string[]|null $peoples_positions A list of physical workplace conditions that if done correct may have prevented the incident.
     * @param string[]|null $attention_to_work A list visual workplace conditions that if done correct may have prevented the incident.
     * @param string[]|null $communication A list communication workplace conditions that if done correct may have prevented the incident.
     * @param bool|null $ppe_in_good_condition If the PPE was in good condition prior to the incident.
     * @param bool|null $ppe_in_use If PPE was in use during the incident.
     * @param bool|null $ppe_correct_type If the correct PPE was used for the environment.
     * @param bool|null $correct_tool_used If the correct tool for the job was used.
     * @param bool|null $policies_followed If the correct workplace policies were followed.
     * @param bool|null $worked_safely If the job was performed in a safe manner.
     * @param bool|null $used_tool_properly If the tool used during the job was used properly.
     * @param bool|null $tool_in_good_condition If the tool was in good condition prior to the incident.
     * @param string[]|null $working_conditions A list physical workplace environment factors that if done correct may have prevented the incident.
     * @param string[]|null $root_causes A list of the top 3 major contributing root causes to the incident.
     */
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

    /**
     * Provides the validation rules for the request.
     *
     * Each individual involved may contain a name email and phone,
     * all of which occur sometimes. Each solution and action may contain a cause,
     * control, remedial action, by whom, and by when.
     * All other arrays are arrays of only strings.
     *
     * @return array The custom validation rules for request data.
     */
    public static function rules(): array
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

    /**
     * Overridden validation messages.
     *
     * @return array The custom validation error messages.
     */
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
