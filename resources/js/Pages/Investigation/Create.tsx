import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import React, { FormEvent } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import { Incident } from '@/types/incident/Incident';

import { InvestigationData } from '@/types/investigation/InvestigationData';
import ResultedIn from '@/Pages/Investigation/Partials/CreateComponents/ResultedIn';
import RiskRating from '@/Pages/Investigation/Partials/CreateComponents/RiskRating';
import Causes from '@/Pages/Investigation/Partials/CreateComponents/Causes';

export interface InvestigationComponentProps {
    formData: InvestigationData;
    setFormData: (key: keyof InvestigationData, value: any) => void;
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
    const setFormData = (key: keyof InvestigationData, value: any) => setData(key, value);

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route('incidents.investigations.store', { incident: incident.id }));
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
            <form
                onSubmit={handleSubmit}
                className="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md"
            >
                <h2 className="text-xl font-bold mb-4">Incident Investigation Form</h2>

                <ResultedIn
                    formData={formData}
                    setFormData={setFormData}
                    errors={errors}
                    toggleCheckbox={toggleCheckbox}
                />

                <RiskRating
                    formData={formData}
                    setFormData={setFormData}
                    errors={errors}
                    toggleCheckbox={toggleCheckbox}
                />

                <Causes
                    formData={formData}
                    setFormData={setFormData}
                    errors={errors}
                    toggleCheckbox={toggleCheckbox}
                />

                <div className="flex justify-end mt-4">
                    <PrimaryButton type="submit" className="px-4 py-2">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
