import GuestLayout from '@/Layouts/GuestLayout';
import StageWrapper from '@/Pages/Incident/Stages/StageWrapper';
import AnonymousStage from '@/Pages/Incident/Stages/AnonymousStage';
import { PageProps } from '@/types';
import React, { useEffect, useState } from 'react';
import AffectedPartyStage from '@/Pages/Incident/Stages/AffectedPartyStage';
import IncidentInformationStage from '@/Pages/Incident/Stages/IncidentInformationStage';
import VictimInformationStage from '@/Pages/Incident/Stages/VictimInformationStage';
import IncidentData from '@/types/IncidentData';
import {
    descriptors,
    roles,
} from '@/Pages/Incident/Stages/IncidentDropDownValues';
import WitnessStage from '@/Pages/Incident/Stages/WitnessStage';
import SupervisorStage from '@/Pages/Incident/Stages/SupervisorStage';
import dateFormat from '@/Filters/dateFormat';
import { router, useForm } from '@inertiajs/react';

export default function Create({
    form,
    auth,
}: PageProps<{ form: IncidentData }>) {
    const {
        data: formData,
        setData,
        post,
        processing,
    } = useForm<IncidentData>(form);
    const { user } = auth;

    const numberOfSteps = 6;
    const [remainingSteps, setRemainingSteps] = useState(numberOfSteps - 1);
    const [currentStepNumber, setCurrentStepNumber] = useState(0);
    const [completedSteps, setCompletedSteps] = useState(0);
    const [validStep, setValidStep] = useState(true);
    const [failedStep, setFailedStep] = useState(false);
    const [showButtons, setShowButtons] = useState(true);
    const setFormData = (key: keyof IncidentData, value: any) =>
        setData(key, value);
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
        setValidStep(true);
        setCurrentStepNumber((prev) => prev - 1);
        setRemainingSteps((prev) => prev + 1);
        setCompletedSteps((prev) => prev - 1);
    };

    const submit = () => {
        post(route('incidents.store'));
    };

    useEffect(() => {
        setFormData('role', roles[0].value);
        setFormData('happened_at', dateFormat(new Date()));
        setFormData('incident_type', descriptors[0].value);
        setFormData('descriptor', descriptors[0].options[0]);
        setFormData('anonymous', true);
        setFormData('on_behalf', false);
        setFormData('on_behalf_anonymous', true);
        setFormData('witnesses', []);
        setFormData('work_related', false);
        setFormData('location', '');
        setFormData('description', '');
    }, []);

    useEffect(() => {
        if (
            !(
                (!formData.anonymous && !formData.on_behalf) ||
                (!formData.anonymous &&
                    formData.on_behalf &&
                    !formData.on_behalf_anonymous) ||
                (formData.anonymous &&
                    formData.on_behalf &&
                    !formData.on_behalf_anonymous)
            )
        ) {
            setFormData('first_name', '');
            setFormData('last_name', '');
            setFormData('phone', '');
            setFormData('email', '');
            setFormData('role', roles[0].value);
            setFormData('upei_id', '');
        }
    }, [formData.on_behalf, formData.on_behalf_anonymous]);

    useEffect(() => {
        if (formData.anonymous) {
            setFormData('reporters_email', '');
        }
    }, [formData.anonymous]);

    return (
        <GuestLayout>
            <form onSubmit={submit}>
                <>
                    <StageWrapper
                        completedSteps={completedSteps}
                        remainingSteps={remainingSteps}
                    >
                        {currentStepNumber === 0 && (
                            <AnonymousStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                                setShowButtons={setShowButtons}
                            />
                        )}
                        {currentStepNumber === 1 && (
                            <AffectedPartyStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                                setShowButtons={setShowButtons}
                            />
                        )}
                        {currentStepNumber === 2 && (
                            <IncidentInformationStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                                setShowButtons={setShowButtons}
                            />
                        )}
                        {currentStepNumber === 3 && (
                            <VictimInformationStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                                setShowButtons={setShowButtons}
                            />
                        )}
                        {currentStepNumber === 4 && (
                            <WitnessStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                                setShowButtons={setShowButtons}
                            />
                        )}
                        {currentStepNumber === 5 && (
                            <SupervisorStage
                                formData={formData}
                                setFormData={setFormData}
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

                        {completedSteps === numberOfSteps - 1 &&
                            showButtons && (
                                <button
                                    type="button"
                                    disabled={processing}
                                    onClick={submit}
                                    className="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                >
                                    Submit
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
                </>
            </form>
        </GuestLayout>
    );
}
