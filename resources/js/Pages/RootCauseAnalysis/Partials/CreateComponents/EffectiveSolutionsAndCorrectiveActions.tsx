import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import DateInput from '@/Components/DateInput';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import PrimaryButtonDivider from '@/Components/PrimaryButtonDivider';
import { PlusIcon } from '@heroicons/react/20/solid';
import classNames from '@/Filters/classNames';
import InputError from '@/Components/InputError';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';

export default function EffectiveSolutionsAndCorrectiveActions({
    formData,
    setFormData,
    errors,
}: RootCauseAnalysisComponentProps) {
    return (
        <div>
            <div className="font-medium text-lg">
                Identity Effective Solutions and Corrective Actions
            </div>
            <div className="flex flex-col w-full">
                {formData.solutions_and_actions.map(
                    ({ cause, control, remedial_action, by_who, by_when, manager }, i) => (
                        <div
                            key={i}
                            className={classNames(
                                'flex flex-col gap-y-2 py-4',
                                i !== formData.solutions_and_actions.length - 1
                                    ? 'border-b border-gray-200'
                                    : ''
                            )}
                        >
                            <div className="flex justify-between">
                                <p className="font-medium">{`Solution #${i + 1}`}</p>
                                {formData.solutions_and_actions.length > 1 && (
                                    <DangerButton
                                        type="button"
                                        onClick={() =>
                                            setFormData('solutions_and_actions', [
                                                ...formData.solutions_and_actions.filter(
                                                    (_, index) => i !== index
                                                ),
                                            ])
                                        }
                                    >
                                        Delete
                                    </DangerButton>
                                )}
                            </div>
                            <InputLabel>
                                <div className="text-gray-900">Cause</div>
                                <div>
                                    The incident would not have occurred if not for the
                                    presence/absence of these factors.
                                </div>
                            </InputLabel>

                            <TextInput
                                value={cause}
                                onChange={(e) => {
                                    formData.solutions_and_actions[i].cause = e.target.value;

                                    setFormData(
                                        'solutions_and_actions',
                                        formData.solutions_and_actions
                                    );
                                }}
                            />
                            <InputError
                                message={
                                    errors[
                                        `solutions_and_actions.${i}.cause` as keyof RootCauseAnalysisData
                                    ]
                                }
                                className="mb-1"
                            />
                            <InputLabel>
                                <div className="text-gray-900">Control</div>
                                <div>
                                    The identified causal factor would not have occurred if the
                                    following control had been in place.{' '}
                                </div>
                            </InputLabel>
                            <TextInput
                                onChange={(e) => {
                                    formData.solutions_and_actions[i].control = e.target.value;
                                    setFormData(
                                        'solutions_and_actions',
                                        formData.solutions_and_actions
                                    );
                                }}
                                value={control}
                            />
                            <InputError
                                message={
                                    errors[
                                        `solutions_and_actions.${i}.control` as keyof RootCauseAnalysisData
                                    ]
                                }
                                className="mb-1"
                            />
                            <InputLabel>Remedial Action Plan</InputLabel>
                            <TextInput
                                onChange={(e) => {
                                    formData.solutions_and_actions[i].remedial_action =
                                        e.target.value;
                                    setFormData(
                                        'solutions_and_actions',
                                        formData.solutions_and_actions
                                    );
                                }}
                                value={remedial_action}
                            />
                            <InputError
                                message={
                                    errors[
                                        `solutions_and_actions.${i}.remedial_action` as keyof RootCauseAnalysisData
                                    ]
                                }
                                className="mb-1"
                            />
                            <InputLabel>Action by Who</InputLabel>
                            <TextInput
                                onChange={(e) => {
                                    formData.solutions_and_actions[i].by_who = e.target.value;
                                    setFormData(
                                        'solutions_and_actions',
                                        formData.solutions_and_actions
                                    );
                                }}
                                value={by_who}
                            />
                            <InputError
                                message={
                                    errors[
                                        `solutions_and_actions.${i}.by_who` as keyof RootCauseAnalysisData
                                    ]
                                }
                                className="mb-1"
                            />
                            <InputLabel>Action by When</InputLabel>
                            <DateInput
                                onChange={(e) => {
                                    formData.solutions_and_actions[i].by_when = e.target.value;
                                    setFormData(
                                        'solutions_and_actions',
                                        formData.solutions_and_actions
                                    );
                                }}
                                value={by_when}
                            />
                            <InputError
                                message={
                                    errors[
                                        `solutions_and_actions.${i}.by_when` as keyof RootCauseAnalysisData
                                    ]
                                }
                                className="mb-1"
                            />
                            <InputLabel>Manager Name</InputLabel>
                            <TextInput
                                onChange={(e) => {
                                    formData.solutions_and_actions[i].manager = e.target.value;
                                    setFormData(
                                        'solutions_and_actions',
                                        formData.solutions_and_actions
                                    );
                                }}
                                value={manager}
                            />
                            <InputError
                                message={
                                    errors[
                                        `solutions_and_actions.${i}.manager` as keyof RootCauseAnalysisData
                                    ]
                                }
                                className="mb-1"
                            />
                        </div>
                    )
                )}
                {formData.solutions_and_actions.length !== 3 && (
                    <PrimaryButtonDivider
                        type="button"
                        onClick={() => {
                            setFormData('solutions_and_actions', [
                                ...formData.solutions_and_actions,
                                {
                                    cause: '',
                                    control: '',
                                    remedial_action: '',
                                    by_who: '',
                                    by_when: '',
                                    manager: '',
                                },
                            ]);
                        }}
                    >
                        <PlusIcon className="size-5" />
                        Add Solution/Correction
                    </PrimaryButtonDivider>
                )}
            </div>
        </div>
    );
}
