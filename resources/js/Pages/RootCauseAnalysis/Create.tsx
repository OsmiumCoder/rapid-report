import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import TextArea from '@/Components/TextArea';
import IndividualsInvolved from '@/Pages/RootCauseAnalysis/Partials/CreateComponents/IndividualsInvolved';
import EffectiveSolutionsAndCorrectiveActions from '@/Pages/RootCauseAnalysis/Partials/CreateComponents/EffectiveSolutionsAndCorrectiveActions';
import IfDoneRightQuestions from '@/Pages/RootCauseAnalysis/Partials/CreateComponents/IfDoneRightQuestions';
import PersonalProtectiveEquipment from '@/Pages/RootCauseAnalysis/Partials/CreateComponents/PersonalProtectiveEquipment';
import RootCauses from '@/Pages/RootCauseAnalysis/Partials/CreateComponents/RootCauses';
import InputError from '@/Components/InputError';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';
import PrimaryButton from '@/Components/PrimaryButton';
import { FormEvent } from 'react';
import ExecutionOfWork from '@/Pages/RootCauseAnalysis/Partials/CreateComponents/ExecutionOfWork';
import { Incident } from '@/types/incident/Incident';

export interface RootCauseAnalysisComponentProps {
    formData: RootCauseAnalysisData;
    setFormData: (key: keyof RootCauseAnalysisData, value: any) => void;
    errors: Partial<Record<keyof RootCauseAnalysisData, string>>;
}

export default function Create({ incident }: { incident: Incident }) {
    const {
        data: formData,
        setData,
        post,
        errors,
    } = useForm({
        individuals_involved: [
            {
                name: '',
                email: '',
                phone: '',
            },
        ],
        whys: Array(5).fill(''),
        primary_effect: '',
        solutions_and_actions: [
            { cause: '', control: '', remedial_action: '', by_who: '', by_when: '', manager: '' },
        ],
        peoples_position: [] as string[],
        attention_to_work: [] as string[],
        communication: [] as string[],
        ppe_in_good_condition: null as boolean | null,
        ppe_in_use: null as boolean | null,
        ppe_correct_type: null as boolean | null,
        correct_tool_used: null as boolean | null,
        policies_followed: null as boolean | null,
        worked_safely: null as boolean | null,
        used_tool_properly: null as boolean | null,
        tool_in_good_condition: null as boolean | null,
        working_conditions: [] as string[],
        root_causes: [] as string[],
    });

    const setFormData = (key: keyof RootCauseAnalysisData, value: any) => setData(key, value);

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        post(route('incidents.root-cause-analyses.store', { incident: incident.id }));
    };
    return (
        <Authenticated>
            <Head title="New Root Cause Analysis" />
            <div className="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md">
                <h3 className="text-lg font-bold text-center">Root Cause Analysis Form</h3>
                <form onSubmit={handleSubmit} className="flex flex-col gap-y-6 ">
                    <IndividualsInvolved
                        formData={formData}
                        setFormData={setFormData}
                        errors={errors}
                    />
                    <div>
                        <InputLabel className="mb-1">
                            <div className="text-gray-900">Primary Effect</div>
                            <div>Define the problem (what happened)</div>
                        </InputLabel>

                        <TextArea
                            value={formData.primary_effect}
                            onChange={(e) => setFormData('primary_effect', e.target.value)}
                        />
                        <InputError message={errors.primary_effect} />
                    </div>
                    <div>
                        <div className="my-2 font-medium">The 5 Why's</div>
                        {formData.whys.map((val, i) => (
                            <div key={i} className="flex flex-col gap-y-2">
                                <InputLabel className="mt-1">{`Why #${i + 1}`}</InputLabel>
                                <TextInput
                                    value={val}
                                    onChange={(e) => {
                                        formData.whys[i] = e.target.value;
                                        setFormData('whys', formData.whys);
                                    }}
                                />
                                <InputError
                                    message={errors[`whys.${i}` as keyof RootCauseAnalysisData]}
                                    className="mb-1"
                                />
                            </div>
                        ))}
                    </div>
                    <EffectiveSolutionsAndCorrectiveActions
                        formData={formData}
                        setFormData={setFormData}
                        errors={errors}
                    />
                    <InputError message={errors.solutions_and_actions} className="mt-2" />
                    <IfDoneRightQuestions
                        formData={formData}
                        setFormData={setFormData}
                        errors={errors}
                    />
                    <PersonalProtectiveEquipment
                        formData={formData}
                        setFormData={setFormData}
                        errors={errors}
                    />
                    <ExecutionOfWork
                        formData={formData}
                        setFormData={setFormData}
                        errors={errors}
                    />
                    <RootCauses formData={formData} setFormData={setFormData} errors={errors} />
                    <PrimaryButton className="w-20 self-center mt-6">Submit</PrimaryButton>
                </form>
            </div>
        </Authenticated>
    );
}
