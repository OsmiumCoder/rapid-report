import GuestLayout from "@/Layouts/GuestLayout";
import ProgressBarsCircle from "@/Components/ProgressBarsCircle";
import Stage from "@/Pages/Incident/Stages/Stage"
import Stage1 from "@/Pages/Incident/Stages/Stage1"
import { PageProps } from "@/types";
import React, { useState } from 'react';
import Stage2 from "./Stages/Stage2";
import Stage3 from "./Stages/Stage3";
import Stage4 from "./Stages/Stage4";

export default function Create({ form }: PageProps<{ form: object }>) {
    const [intitialFormData, setFormData] = useState({
        anon: false,
        onbehalf: false,
        onbehalf_anon: false,
        role: '',
        first_name: '',
        last_name: '',
        phone_number: '',
        work_related: false,
        was_injured: false,
        fa_applied: false,
        injury_description: '',
        fa_description: '',
        location: '',
        room_number: '',
        incident_type: '',
        incident_catagory: '',
        description: '',
        other_des: ''

    });
    const [stage, setStage] = useState(0);
    const [steps, setStep] = useState([
        { name: 'Step 1', status: 'current' },
        { name: 'Step 2', status: 'upcoming' },
        { name: 'Step 3', status: 'upcoming' },
        { name: 'Step 4', status: 'upcoming' },
    ]);

    const handleChange = (e) => {
        console.log(e.target);
        const { name, value } = e.target;
        setFormData(prevState => ({
            ...prevState,
            [name]: value
        }));
    };
    const handleBoolChange = (e) => {
        const { name, checked } = e.target;
        console.log({ name, checked });
        setFormData(prevState => ({
            ...prevState,
            [name]: checked
        }));
        console.log(intitialFormData);
    };
    const nextStep = () => {
        setStage(stage + 1);
        console.log((stage === 0) && intitialFormData.anon)
        if (stage === 0 && intitialFormData.anon) {
            setStage(2);
        }
        let newSteps = steps;
        let i = 0
        console.log(steps);
        while (i < newSteps.length) {
            if (newSteps[i].status == 'current') {
                newSteps[i].status = 'complete';
                if (i + 1 < newSteps.length) {
                    if(intitialFormData.anon && stage==0) {
                        newSteps[i + 1].status = "complete";
                        newSteps[i + 2].status = "current";
                    } else {
                        newSteps[i + 1].status = "current";
                    }

                }
                break;
            }
            i++;
        }
        setStep(newSteps);
    }
    const lastStep = () => {
        console.log(intitialFormData.anon);
        setStage(stage - 1);
        if (stage === 2 && intitialFormData.anon) {
            setStage(0);
        }
        let newSteps = steps;
        let i = 0
        while (i < newSteps.length) {
            if (newSteps[i].status == 'current') {
                newSteps[i].status = 'upcoming';
                if (i - 1 >= 0) {
                    if (intitialFormData.anon && stage == 2) {
                        newSteps[i - 1].status = "upcoming";
                        newSteps[i - 2].status = "current";
                    } else {
                        newSteps[i - 1].status = "current";
                    }
                }
                break;
            }
            i++;
        }
        setStep(newSteps);
    }
    const submit = () => {
        console.log(intitialFormData);
    }


    return (
        <GuestLayout>
            <form onSubmit={submit}>
                {stage === 0 && (
                    <>
                        <Stage
                            s_amount={steps.length}
                            current_s={stage}
                        >
                            <Stage1
                                boolHandle={handleBoolChange}
                                currentData={intitialFormData}
                            >
                            </Stage1>
                        </Stage>
                        <div className="flex justify-center">
                        <button type="button" onClick={nextStep} className="static right-0 mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Next
                            </button>
                        </div>
                    </>

                )}
                {stage === 1 && (
                    <>
                        <Stage
                            s_amount={steps.length}
                            current_s={stage}
                        >
                            <Stage2
                                dataHandle={handleChange}
                                currentData={intitialFormData}
                            >

                            </Stage2>
                        </Stage>
                        <div className="flex justify-center">
                            <div>
                                <button type="button" onClick={lastStep} className="object-left mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Back
                                </button>
                            </div>
                            <div>

                        <button type="button" onClick={nextStep} className="object-left mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Next
                                </button>
                            </div>

                        </div>

                    </>
                )}
                {stage === 2 && (
                    <>
                        <Stage
                            s_amount={steps.length}
                            current_s={stage}
                        >
                            <Stage3
                                boolHandle={handleBoolChange}
                                dataHandle={handleChange}
                                currentData={intitialFormData}
                            >
                            </Stage3>
                        </Stage>
                        <div className="flex justify-center">
                        <button type="button" onClick={lastStep} className="mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </button>
                            <button type="button" onClick={nextStep} className="mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Next
                            </button>
                        </div>
                    </>
                )}
                {stage === 3 && (
                    <>
                        <Stage
                            s_amount={steps.length}
                            current_s={stage}
                        >
                            <Stage4
                                boolHandle={handleBoolChange}
                                dataHandle={handleChange}
                                currentData={intitialFormData}
                            >
                            </Stage4>
                        </Stage>
                        <div className="flex p-8">
                            <button type="button" onClick={lastStep} className="mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Back
                            </button>

                            <button type="button" onClick={submit} className=" mt-4 mx-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Submit
                            </button>
                            <button type="button" onClick={nextStep} className="mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Next
                            </button>
                        </div>
                    </>
                )}

            </form>

        </GuestLayout>
    );
}
