import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import DangerButton from '@/Components/DangerButton';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import validatePhoneInput from '@/Filters/validatePhoneInput';
import classNames from '@/Filters/classNames';
import { PlusIcon } from '@heroicons/react/20/solid';
import PrimaryButtonDivider from '@/Components/PrimaryButtonDivider';
import InputError from '@/Components/InputError';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';

export default function IndividualsInvolved({
    formData,
    setFormData,
    errors,
}: RootCauseAnalysisComponentProps) {
    return (
        <div>
            <div className="font-medium text-lg">Individuals Involved</div>
            <div className="flex flex-col w-full">
                {formData.individuals_involved.map(({ name, email, phone }, i) => (
                    <div
                        key={i}
                        className={classNames(
                            'flex flex-col gap-y-2 py-4',
                            i !== formData.individuals_involved.length - 1
                                ? 'border-b border-gray-200'
                                : ''
                        )}
                    >
                        <div className="flex justify-between">
                            <p>{`Individual #${i + 1}`}</p>
                            {formData.individuals_involved.length > 1 && (
                                <DangerButton
                                    type="button"
                                    onClick={() =>
                                        setFormData('individuals_involved', [
                                            ...formData.individuals_involved.filter(
                                                (_, index) => i !== index
                                            ),
                                        ])
                                    }
                                >
                                    Delete
                                </DangerButton>
                            )}
                        </div>
                        <InputLabel>Name</InputLabel>
                        <TextInput
                            value={name}
                            onChange={(e) => {
                                formData.individuals_involved[i].name = e.target.value;
                                setFormData('individuals_involved', formData.individuals_involved);
                            }}
                        />
                        <InputError
                            message={
                                errors[
                                    `individuals_involved.${i}.name` as keyof RootCauseAnalysisData
                                ]
                            }
                            className="mb-1"
                        />
                        <InputLabel>Email</InputLabel>
                        <TextInput
                            onChange={(e) => {
                                formData.individuals_involved[i].email = e.target.value;
                                setFormData('individuals_involved', formData.individuals_involved);
                            }}
                            value={email}
                        />
                        <InputError
                            message={
                                errors[
                                    `individuals_involved.${i}.email` as keyof RootCauseAnalysisData
                                ]
                            }
                            className="mb-1"
                        />
                        <InputLabel>Phone</InputLabel>
                        <TextInput
                            onChange={(e) => {
                                formData.individuals_involved[i].phone = validatePhoneInput(
                                    e.target.value
                                );
                                setFormData('individuals_involved', formData.individuals_involved);
                            }}
                            value={phone}
                        />
                        <InputError
                            message={
                                errors[
                                    `individuals_involved.${i}.phone` as keyof RootCauseAnalysisData
                                ]
                            }
                            className="mb-1"
                        />
                    </div>
                ))}
                <PrimaryButtonDivider
                    type="button"
                    className="self-end"
                    onClick={() =>
                        setFormData('individuals_involved', [
                            ...formData.individuals_involved,
                            { name: '', email: '', phone: '' },
                        ])
                    }
                >
                    <PlusIcon className="size-5" />
                    Add Individual
                </PrimaryButtonDivider>
            </div>
        </div>
    );
}
