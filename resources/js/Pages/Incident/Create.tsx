import GuestLayout from "@/Layouts/GuestLayout";
import ProgressBarsCircle from "@/Components/ProgressBarsCircle";
import { PageProps } from "@/types";
import { ChevronDownIcon } from '@heroicons/react/16/solid'
import React, { useState } from 'react';

export default function Create({ form }: PageProps<{ form: object }>) {
    const [intitialFormData, setFormData] = useState({
        anon: false,
        role: 'Victim',
        first_name: '',
        last_name: '',
        phone_number: '',
        work_related: Boolean,
        location: '',
        room_number: '',
        incident_type: '',
        description: '',

    });
    const [stage, setStage] = useState(0);
    const [steps, setStep] = useState([
        { name: 'Step 1', status: 'current' },
        { name: 'Step 2', status: 'upcoming' },
        { name: 'Step 3', status: 'upcoming' },
        { name: 'Step 4', status: 'upcoming' },
        { name: 'Step 5', status: 'upcoming' },
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
                        
                        <div className="divide-y divide-gray-200 ">
                            <div className="relative flex items-center">
                            <ProgressBarsCircle
                                steps={steps} className="relative flex gap-3">
                                </ProgressBarsCircle>
                            </div>
                            <div className="relative flex gap-3 pb-4 pt-3.5 mt-4">
                        <div className="min-w-0 flex-1 text-sm/6">
                            <label htmlFor="anon" className="font-medium text-gray-900">
                                        Anonymity
                            </label>
                                    <p id="anon-description" className="text-gray-500">
                                Would you like to remain anonymous?
                            </p>
                        </div>
                        <div className="flex h-6 shrink-0 items-center">
                            <div className="group grid size-4 grid-cols-1">
                        <input
                            id="anon"
                            name="anon"
                            type="checkbox"
                                            aria-describedby="anon-description"
                            value={intitialFormData.anon}
                            onChange={handleBoolChange}
                            className="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                        />
                        <svg
                            fill="none"
                            viewBox="0 0 14 14"
                            className="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                        >
                            <path
                                d="M3 8L6 11L11 3.5"
                                strokeWidth={2}
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                className="opacity-0 group-has-[:checked]:opacity-100"
                            />
                            <path
                                d="M3 7H11"
                                strokeWidth={2}
                                strokeLinecap="round"
                                strokeLinejoin="round"
                                className="opacity-0 group-has-[:indeterminate]:opacity-100"
                            />
                                </svg>
                            </div>
                            </div>
                       
                            </div>
                        </div>
                        <div className="right">
                            <button type="button" onClick={nextStep} className="static right-0 mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Next
                            </button>
                        </div>
                        
                        </>
                )}
                {stage === 1 && (
                    <>
                        <div>
                            <ProgressBarsCircle
                                steps={steps}
                            >
                            </ProgressBarsCircle>
                        </div>
                        <label className="flex object-center font-bold text-m/9 font-medium text-gray-900">
                            Personal Information
                        </label>
                        <div>
                            <label htmlFor="first_name" className="block text-sm/6 font-medium text-gray-900">
                                First Name
                            </label>
                            <div className="mt-2">
                                <input
                                    id="first_name"
                                    name="first_name"
                                    required
                                    value={intitialFormData.first_name}
                                    onChange={handleChange}
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                            </div>
                        </div>

                        <div>
                            <div className="flex items-center justify-between">
                                <label htmlFor="last_name" className="block text-sm/6 font-medium text-gray-900">
                                    Last Name
                                </label>
                            </div>
                            <div className="mt-2">
                                <input
                                    id="last_name"
                                    name="last_name"
                                    required
                                    value={intitialFormData.last_name}
                                    onChange={handleChange}
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                            </div>
                        </div>
                        <div>
                            <label htmlFor="phone_number" className="block text-sm/6 font-medium text-gray-900">
                                Phone Number
                            </label>
                            <div className="mt-2">
                                <input
                                    id="phone_number"
                                    name="phone_number"
                                    required
                                    value={intitialFormData.phone_number}
                                    onChange={handleChange}
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                            </div>
                        </div>
                        <div>
                            <label htmlFor="role" className="block text-sm/6 font-medium text-gray-900">
                                Incident Role
                            </label>
                            <div className="mt-2 grid grid-cols-1">
                                <select
                                    id="role"
                                    name="role"
                                    defaultValue="Victim"
                                    value={intitialFormData.role}
                                    onChange={handleChange}
                                    className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                >
                                    <option>Victim</option>
                                    <option>Supervisor</option>
                                    <option>Witness</option>
                                </select>
                                <ChevronDownIcon
                                    aria-hidden="true"
                                    className="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                />
                            </div>
                        </div>
                        <button type="button" onClick={lastStep} className="object-left mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </button>
                        <button type="button" onClick={nextStep} className="object-left mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Next
                        </button>
                    </>
                )}
                {stage === 2 && (
                    <>
                        <div>
                            <ProgressBarsCircle
                                steps={steps}
                            >
                            </ProgressBarsCircle>
                        </div>

                        <label className="flex object-center font-bold text-m/9 font-medium text-gray-900">
                            Incident Information
                        </label>
                        <button type="button" onClick={lastStep} className="object-left mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Back
                        </button>
                        <button type="button" onClick={nextStep} className="object-left mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Next
                        </button>
                        <button type="button" onClick={submit} className="object-right mt-4 mx-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Submit
                        </button>
                    </>
                )}

            </form>
            
        </GuestLayout>
    );
}
