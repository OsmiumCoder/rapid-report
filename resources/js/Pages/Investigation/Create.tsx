import PrimaryButton from '@/Components/PrimaryButton';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Incident } from '@/types/incident/Incident';
import { Head, useForm } from '@inertiajs/react';
import { FormEvent } from 'react';

import Causes from '@/Pages/Investigation/Partials/CreateComponents/Causes';
import ResultedIn from '@/Pages/Investigation/Partials/CreateComponents/ResultedIn';
import RiskRating from '@/Pages/Investigation/Partials/CreateComponents/RiskRating';
import { InvestigationData } from '@/types/investigation/InvestigationData';

export interface InvestigationComponentProps {
    formData: InvestigationData;
    setFormData: (key: keyof InvestigationData, value: InvestigationData[keyof InvestigationData]) => void;
    errors: Partial<Record<keyof InvestigationData, string>>;
    toggleCheckbox: (category: keyof InvestigationData, value: string) => void;
}

export default function Create({ incident }: { incident: Incident }) {
    const {
        data: formData,
        setData,
        post,
        errors,
    } = useForm({
        immediate_causes: '',
        basic_causes: '',
        remedial_actions: '',
        prevention: '',
        risk_rank: 1,
        resulted_in: [] as string[],
        substandard_acts: [] as string[],
        substandard_conditions: [] as string[],
        energy_transfer_causes: [] as string[],
        personal_factors: [] as string[],
        job_factors: [] as string[],
    });
    const setFormData = (key: keyof InvestigationData, value: InvestigationData[keyof InvestigationData]) => setData(key, value);

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route('incidents.investigations.store', { incident: incident.slug }));
    };

    const toggleCheckbox = (category: keyof InvestigationData, value: string) => {
        const updatedList = (formData[category] as string[]).includes(value)
            ? (formData[category] as string[]).filter((item) => item !== value)
            : [...(formData[category] as string[]), value];
        setFormData(category, updatedList);
    };

    return (
        <AuthenticatedLayout>
            <Head title="New Investigation" />
            <form onSubmit={handleSubmit} className="mx-auto max-w-4xl rounded-md bg-white p-6 shadow-md">
                <h2 className="mb-4 text-xl font-bold">Incident Investigation Form</h2>

                <ResultedIn formData={formData} setFormData={setFormData} errors={errors} toggleCheckbox={toggleCheckbox} />

                <RiskRating formData={formData} setFormData={setFormData} errors={errors} toggleCheckbox={toggleCheckbox} />

                <Causes formData={formData} setFormData={setFormData} errors={errors} toggleCheckbox={toggleCheckbox} />

                <div className="mt-4 flex justify-end">
                    <PrimaryButton type="submit" className="px-4 py-2">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
