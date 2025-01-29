import GuestLayout from '@/Layouts/GuestLayout';
import StageWrapper from '@/Pages/Incident/Stages/StageWrapper';
import AnonymousStage from '@/Pages/Incident/Stages/AnonymousStage';
import { PageProps } from '@/types';
import React, { useEffect, useState } from 'react';
import AffectedPartyStage from '@/Pages/Incident/Stages/AffectedPartyStage';
import IncidentInformationStage from '@/Pages/Incident/Stages/IncidentInformationStage';
import VictimInformationStage from '@/Pages/Incident/Stages/VictimInformationStage';
import IncidentData from '@/types/IncidentData';
import { descriptors, roles } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import WitnessStage from '@/Pages/Incident/Stages/WitnessStage';
import SupervisorStage from '@/Pages/Incident/Stages/SupervisorStage';
import dateFormat from '@/Filters/dateFormat';
import { useForm } from '@inertiajs/react';

export default function Create({ form }: PageProps<{ form: IncidentData }>) {
    const { data, setData, post, processing } = useForm(form);

    const numberOfSteps = 6;
    const [remainingSteps, setRemainingSteps] = useState(numberOfSteps - 1);
    const [currentStepNumber, setCurrentStepNumber] = useState(0);
    const [completedSteps, setCompletedSteps] = useState(0);
    const [validStep, setValidStep] = useState(true);
    const [failedStep, setFailedStep] = useState(false);
    const [showButtons, setShowButtons] = useState(true);

    const nextStep = () => {
        if (validStep) {
            setCurrentStepNumber((prev) => prev + 1);
            setRemainingSteps((prev) => prev - 1);
            setCompletedSteps((prev) => prev + 1);
            setFailedStep(false);
        } else {
            setFailedStep(true);
        }
    };

    const prevStep = () => {
        setFailedStep(false);
        setCurrentStepNumber((prev) => prev - 1);
        setRemainingSteps((prev) => prev + 1);
        setCompletedSteps((prev) => prev - 1);
    };

    const submit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('incidents.store'));
    };

    useEffect(() => {
        setData({
            ...data,
            role: roles[0].value,
            happened_at: dateFormat(new Date()),
            incident_type: descriptors[0].value,
            descriptor: descriptors[0].options[0],
            anonymous: true,
            on_behalf: false,
            on_behalf_anon: true,
            witnesses: [],
        });
    }, []);

    useEffect(() => {
        if (
            !(
                (!data.anonymous && !data.on_behalf) ||
                (!data.anonymous &&
                    data.on_behalf &&
                    !data.on_behalf_anon) ||
                (data.anonymous &&
                    data.on_behalf &&
                    !data.on_behalf_anon)
            )
        ) {
            setData({
                ...data,
                first_name: '',
                last_name: '',
                phone: '',
                email: '',
                role: roles[0].value,
                upei_id: '',
            });
        }
    }, [data.on_behalf, data.on_behalf_anon]);

    useEffect(() => {
        setData({
            ...data,
            reporters_email: '',
        });
    }, [data.anonymous]);

    return (
        <GuestLayout>
            <form onSubmit={submit}>
                <StageWrapper completedSteps={completedSteps} remainingSteps={remainingSteps}>
                    {currentStepNumber === 0 && (
                        <AnonymousStage
                            formData={data}
                            setFormData={setData}
                            validStep={validStep}
                            setValidStep={setValidStep}
                            failedStep={failedStep}
                            setShowButtons={setShowButtons}
                        />
                    )}
                    {currentStepNumber === 1 && (
                        <AffectedPartyStage
                            formData={data}
                            setFormData={setData}
                            validStep={validStep}
                            setValidStep={setValidStep}
                            failedStep={failedStep}
                            setShowButtons={setShowButtons}
                        />
                    )}
                    {currentStepNumber === 2 && (
                        <IncidentInformationStage
                            formData={data}
                            setFormData={setData}
                            validStep={validStep}
                            setValidStep={setValidStep}
                            failedStep={failedStep}
                            setShowButtons={setShowButtons}
                        />
                    )}
                    {currentStepNumber === 3 && (
                        <VictimInformationStage
                            formData={data}
                            setFormData={setData}
                            validStep={validStep}
                            setValidStep={setValidStep}
                            failedStep={failedStep}
                            setShowButtons={setShowButtons}
                        />
                    )}
                    {currentStepNumber === 4 && (
                        <WitnessStage
                            formData={data}
                            setFormData={setData}
                            validStep={validStep}
                            setValidStep={setValidStep}
                            failedStep={failedStep}
                            setShowButtons={setShowButtons}
                        />
                    )}
                    {currentStepNumber === 5 && (
                        <SupervisorStage
                            formData={data}
                            setFormData={setData}
                            validStep={validStep}
                            setValidStep={setValidStep}
                            failedStep={failedStep}
                            setShowButtons={setShowButtons}
                        />
                    )}
                </StageWrapper>

                <div className="flex p-6 justify-around">
                    {completedSteps > 0 && showButtons && (
                        <button
                            type="button"
                            onClick={prevStep}
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Back
                        </button>
                    )}

                    {completedSteps === numberOfSteps - 1 && showButtons && (
                        <button
                            type="submit"
                            disabled={processing}
                            className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                        >
                            {processing ? 'Submitting...' : 'Submit'}
                        </button>
                    )}

                    {remainingSteps > 0 && showButtons && (
                        <button
                            type="button"
                            onClick={nextStep}
                            className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Next
                        </button>
                    )}
                </div>
            </form>
        </GuestLayout>
    );
}
