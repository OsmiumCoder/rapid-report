import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import DateInput from '@/Components/DateInput';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';

export default function EffectiveSolutionsAndCorrectiveActions({
    formData,
    setFormData,
}: RootCauseAnalysisComponentProps) {
    return (
        <>
            <div className="font-medium text-lg">
                Identity Effective Solutions and Corrective Actions
            </div>
            <div className="flex flex-col w-full">
                {formData.solutions_and_actions.map(
                    ({ cause, control, remedial_action, by_who, by_when, manager }, i) => (
                        <div
                            key={i}
                            className="flex flex-col gap-y-2 border-b border-gray-200 py-2"
                        >
                            <p className="font-medium text-md">{`Solution #${i + 1}`}</p>
                            <InputLabel>
                                <span className="text-gray-900">Cause</span>
                                <span>
                                    {' '}
                                    - The incident would not have occurred if not for the
                                    presence/absence of these factors.
                                </span>
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
                            <InputLabel>
                                <span className="text-gray-900">Control</span>
                                <span>
                                    {' '}
                                    - The identified causal factor would not have occurred if the
                                    following control had been in place.{' '}
                                </span>
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
                        </div>
                    )
                )}
                <div className="flex justify-between items-center my-2">
                    {formData.solutions_and_actions.length !== 3 && (
                        <PrimaryButton
                            type="button"
                            className="self-end"
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
                            Add
                        </PrimaryButton>
                    )}
                    {formData.solutions_and_actions.length > 1 && (
                        <DangerButton
                            type="button"
                            onClick={() =>
                                setFormData(
                                    'solutions_and_actions',
                                    formData.solutions_and_actions.splice(
                                        0,
                                        formData.solutions_and_actions.length - 1
                                    )
                                )
                            }
                        >
                            Delete
                        </DangerButton>
                    )}
                </div>
            </div>
        </>
    );
}
