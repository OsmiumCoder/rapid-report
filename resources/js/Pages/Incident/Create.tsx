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
import AdditionalPersonsStage from "@/Pages/Incident/Stages/AdditionalPersonsStage";

export default function Create({ form }: PageProps<{ form: IncidentData }>) {
    const [formData, setFormData] = useState<IncidentData>(form);

    const numberOfSteps = 5;
    const [remainingSteps, setRemainingSteps] = useState(numberOfSteps - 1);
    const [currentStepNumber, setCurrentStepNumber] = useState(0);
    const [completedSteps, setCompletedSteps] = useState(0);

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

    useEffect(() => {
        setFormData((prev) => ({
            ...prev,
            role: roles[0].value,
            incident_type: descriptors[0].value,
            descriptor: descriptors[0].options[0],
            anonymous: true,
            on_behalf: false,
            on_behalf_anon: true
        }));
    }, []);

    useEffect(() => {
        if (!((!formData.anonymous && !formData.on_behalf) ||
            (!formData.anonymous && formData.on_behalf && !formData.on_behalf_anon) ||
            (formData.anonymous && formData.on_behalf && !formData.on_behalf_anon))) {
            setFormData((prev) => ({
                ...prev,
                first_name: '',
                last_name: '',
                phone: '',
                email: '',
                role: roles[0].value,
                upei_id: ''
            }));
        }



    }, [formData.on_behalf, formData.on_behalf_anon]);

    useEffect(() => {
        setFormData((prev) => ({
            ...prev,
            reporters_email: undefined
        }));
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
                            />
                        )}
                        {currentStepNumber === 1 && (
                            <AffectedPartyStage
                                formData={formData}
                                setFormData={setFormData}
                            />
                        )}
                        {currentStepNumber === 2 && (
                            <IncidentInformationStage
                                formData={formData}
                                setFormData={setFormData}
                            />
                        )}
                        {currentStepNumber === 3 && (
                            <VictimInformationStage
                                formData={formData}
                                setFormData={setFormData}
                            />
                        )}
                        {currentStepNumber === 4 && (
                            <AdditionalPersonsStage
                                formData={formData}
                                setFormData={setFormData}
                            />
                        )}
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

                        {completedSteps === numberOfSteps - 1 && (
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
            </form>
        </GuestLayout>
    );
}
