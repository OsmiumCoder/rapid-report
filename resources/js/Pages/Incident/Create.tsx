import GuestLayout from '@/Layouts/GuestLayout';
import StageWrapper from '@/Pages/Incident/Stages/StageWrapper';
import AnonymousStage from '@/Pages/Incident/Stages/AnonymousStage';
import { PageProps } from '@/types';
import React, { ReactElement, useEffect, useState } from 'react';
import AffectedPartyStage from '@/Pages/Incident/Stages/AffectedPartyStage';
import IncidentInformationStage from '@/Pages/Incident/Stages/IncidentInformationStage';
import VictimInformationStage from '@/Pages/Incident/Stages/VictimInformationStage';
import IncidentData from '@/types/IncidentData';

export default function Create({ form }: PageProps<{ form: IncidentData }>) {
    const [formData, setFormData] = useState<IncidentData>(form);

    const steps: ReactElement[] = [
        <AnonymousStage formData={formData} setFormData={setFormData} />,
        <AffectedPartyStage formData={formData} setFormData={setFormData} />,
        <IncidentInformationStage
            formData={formData}
            setFormData={setFormData}
        />,
        <VictimInformationStage
            formData={formData}
            setFormData={setFormData}
        />,
    ];

    const [remainingSteps, setRemainingSteps] = useState(steps.length - 1);

    const [currentStepNumber, setCurrentStepNumber] = useState(0);

    const [CurrentStep, setCurrentStep] = useState<ReactElement>(
        steps[currentStepNumber]
    );

    const [completedSteps, setCompletedSteps] = useState(0);

    useEffect(() => {
        setCurrentStep(steps[currentStepNumber]);
    }, [currentStepNumber]);

    const nextStep = () => {
        setCurrentStepNumber((prev) => prev + 1);
        setRemainingSteps((prev) => prev - 1);
        setCompletedSteps((prev) => prev + 1);
    };

    const prevStep = () => {
        setCurrentStepNumber((prev) => prev - 1);
        setRemainingSteps((prev) => prev + 1);
        setCompletedSteps((prev) => prev - 1);
    };

    const submit = () => {
        console.log(formData);
    };

    return (
        <GuestLayout>
            <form onSubmit={submit}>
                {
                    <>
                        <StageWrapper
                            completedSteps={completedSteps}
                            remainingSteps={remainingSteps}
                        >
                            {CurrentStep}
                        </StageWrapper>

                        <div className="flex p-8 items-center justify-center">
                            {completedSteps > 0 && (
                                <button
                                    type="button"
                                    onClick={prevStep}
                                    className="mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Back
                                </button>
                            )}

                            {completedSteps === steps.length - 1 && (
                                <button
                                    type="button"
                                    onClick={submit}
                                    className=" mt-4 mx-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Submit
                                </button>
                            )}
                            {remainingSteps > 0 && (
                                <button
                                    type="button"
                                    onClick={nextStep}
                                    className="mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Next
                                </button>
                            )}
                        </div>
                    </>
                }
            </form>
        </GuestLayout>
    );
}
