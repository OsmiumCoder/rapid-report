import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React, { useEffect } from 'react';
import { usePage } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';

export default function SupervisorStage({
    formData,
    setFormData,
    setValidStep,
    failedStep,
}: StageProps) {
    const { auth } = usePage().props;

    useEffect(() => {
        handleValidStep();
    });

    const handleValidStep = () => {
        if (auth.user !== null && formData.supervisor_name?.length === 0 && !formData.anonymous) {
            setValidStep(false);
        } else {
            setValidStep(true);
        }
    };

    return (
        <div className="min-w-0 flex-1 text-sm/6 space-y-4">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Supervisor
            </label>

            <div>
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Supervisor Name
                    </label>
                    <p className="text-xs text-gray-500">
                        A supervisor is a person who provides direction to workers on their
                        work-related tasks and can include any worker, manager, or employer
                        regardless of whether or not they have the title of “supervisor”.
                    </p>
                </div>
                <div className="mt-2">
                    <TextInput
                        value={formData.supervisor_name ?? ''}
                        onChange={(e) => {
                            setFormData('supervisor_name', e.target.value);
                            handleValidStep();
                        }}
                    />
                    {failedStep && <span className="text-red-600">Supervisor name required</span>}
                </div>
            </div>
        </div>
    );
}
