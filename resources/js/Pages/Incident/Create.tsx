import DangerButton from '@/Components/DangerButton';
import PrimaryButton from '@/Components/PrimaryButton';
import dateFormat from '@/Formatters/dateFormat';
import GuestLayout from '@/Layouts/GuestLayout';
import AffectedPartyStage from '@/Pages/Incident/Stages/AffectedPartyStage';
import AnonymousStage from '@/Pages/Incident/Stages/AnonymousStage';
import { descriptors, roles } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import IncidentInformationStage from '@/Pages/Incident/Stages/IncidentInformationStage';
import ReviewStage from '@/Pages/Incident/Stages/ReviewStage';
import StageWrapper from '@/Pages/Incident/Stages/StageWrapper';
import SupervisorStage from '@/Pages/Incident/Stages/SupervisorStage';
import VictimInformationStage from '@/Pages/Incident/Stages/VictimInformationStage';
import WitnessStage from '@/Pages/Incident/Stages/WitnessStage';
import { PageProps } from '@/types';
import { Incident } from '@/types/incident/Incident';
import IncidentData from '@/types/incident/IncidentData';
import { Head, useForm } from '@inertiajs/react';
import { useCallback, useEffect, useState } from 'react';

export default function Create({ form }: PageProps<{ form: IncidentData }>) {
    const { data: formData, setData, post, processing } = useForm<Partial<IncidentData>>(form);

    const numberOfSteps = 7;
    const [remainingSteps, setRemainingSteps] = useState(numberOfSteps - 1);
    const [currentStepNumber, setCurrentStepNumber] = useState(0);
    const [completedSteps, setCompletedSteps] = useState(0);
    const [validStep, setValidStep] = useState(true);
    const [failedStep, setFailedStep] = useState(false);
    const [showButtons, setShowButtons] = useState(true);
    const setFormData = useCallback((key: keyof IncidentData, value: IncidentData[keyof IncidentData]) => setData(key, value), [setData]);
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
        if (validStep) {
            post(route('incidents.store'), {
                onError: (err) => console.error(err),
            });
        } else {
            setFailedStep(true);
        }
    };

    useEffect(() => {
        setFormData('role', roles[0].value);
        setFormData('happened_at', dateFormat(new Date()));
        setFormData('incident_type', descriptors[0].value);
        setFormData('descriptor', descriptors[0].options[0]);
        setFormData('anonymous', true);
        setFormData('on_behalf', false);
        setFormData('on_behalf_anonymous', true);
        setFormData('work_related', false);
        setFormData('has_injury', false);
        setFormData('workers_comp_submitted', false);
        setFormData('supervisor_name', '');
    }, [setFormData]);

    useEffect(() => {
        if (
            !(
                (!formData.anonymous && !formData.on_behalf) ||
                (!formData.anonymous && formData.on_behalf && !formData.on_behalf_anonymous) ||
                (formData.anonymous && formData.on_behalf && !formData.on_behalf_anonymous)
            )
        ) {
            setFormData('first_name', '');
            setFormData('last_name', '');
            setFormData('phone', '');
            setFormData('email', '');
            setFormData('role', '');
            setFormData('upei_id', '');
        }
        else {
            setFormData('role', roles[0].value);
        }
    }, [formData.on_behalf, formData.on_behalf_anonymous, formData.anonymous, setFormData]);

    useEffect(() => {
        if (formData.anonymous && !formData.on_behalf) {
            setFormData('reporters_email', '');
            setFormData('first_name', '');
            setFormData('last_name', '');
            setFormData('phone', '');
            setFormData('email', '');
            setFormData('role', '');
            setFormData('upei_id', '');
        }
        else {
            setFormData('role', roles[0].value);
        }
    }, [formData.anonymous, formData.on_behalf, setFormData]);

    return (
        <GuestLayout>
            <Head title="Submit Incident" />
            <form onSubmit={submit}>
                <>
                    <StageWrapper completedSteps={completedSteps} remainingSteps={remainingSteps}>
                        {currentStepNumber === 0 && (
                            <AnonymousStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                            />
                        )}
                        {currentStepNumber === 1 && (
                            <AffectedPartyStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                            />
                        )}
                        {currentStepNumber === 2 && (
                            <IncidentInformationStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
                            />
                        )}
                        {currentStepNumber === 3 && (
                            <VictimInformationStage
                                formData={formData}
                                setFormData={setFormData}
                                validStep={validStep}
                                setValidStep={setValidStep}
                                failedStep={failedStep}
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
                            />
                        )}
                        {currentStepNumber === 6 && <ReviewStage incidentData={formData as Incident} />}
                    </StageWrapper>

                    <div className="flex justify-around p-6">
                        {completedSteps > 0 && showButtons && (
                            <DangerButton type="button" onClick={prevStep}>
                                Back
                            </DangerButton>
                        )}

                        {completedSteps === numberOfSteps - 1 && showButtons && (
                            <PrimaryButton type="button" onClick={submit} disabled={processing}>
                                Submit
                            </PrimaryButton>
                        )}

                        {remainingSteps > 0 && remainingSteps < numberOfSteps && showButtons && (
                            <PrimaryButton type="button" onClick={nextStep}>
                                Next
                            </PrimaryButton>
                        )}
                    </div>
                </>
            </form>
        </GuestLayout>
    );
}
