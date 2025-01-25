import React, { useEffect } from 'react';
import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import { descriptors } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import ToggleSwitch from '@/Components/ToggleSwitch';

export default function IncidentInformationStage({
    formData,
    setFormData,
    failedStep,
    setValidStep,
}: StageProps) {
    useEffect(() => {
        handleValidStep();
    });

    const handleValidStep = () => {
        if (formData.location == '') {
            setValidStep(false);
        } else {
            setValidStep(true);
        }
    }

    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Incident Information
            </label>

            <div className="flex">
                <div className="min-w-0 flex-1 text-sm/6">
                    <label
                        htmlFor="work_related"
                        className="font-medium text-gray-900"
                    >
                        Work Related
                    </label>
                    <p className="text-xs text-gray-500">
                        Was the Incident Work related?
                    </p>
                </div>
                <ToggleSwitch
                    checked={formData.work_related ?? false}
                    onChange={(e) => {
                        setFormData((prev) => ({
                            ...prev,
                            work_related: e.valueOf(),
                        }));
                    }}
                />
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Location
                    </label>
                    <p className="text-xs text-gray-500">
                        Enter the building or description of area where the
                        incident occurred.
                    </p>
                </div>

                <div className="mt-2">
                    <input
                        placeholder="e.g Cass Science Hall"
                        aria-describedby="location-description"
                        required
                        value={formData.location ?? ''}
                        onChange={(e) => {
                            setFormData((prev) => ({
                                ...prev,
                                location: e.target.value,
                            }));
                            handleValidStep();
                        }}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                    {failedStep && formData.location == '' && (
                        <p
                            id="validation-error"
                            className="mt-2 text-sm text-red-600"
                        >
                            *Please enter the location
                        </p>
                    )}
                </div>
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Room Number
                    </label>
                    <p className="text-xs text-gray-500">If Applicable.</p>
                </div>

                <div className="mt-2">
                    <input
                        placeholder="e.g 123A"
                        required
                        value={formData.room_number ?? ''}
                        onChange={(e) => {
                            setFormData((prev) => ({
                                ...prev,
                                room_number: e.target.value,
                            }));
                        }}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Incident Type
                    </label>
                </div>
                <div className="mt-1 grid grid-cols-1">
                    <select
                        value={
                            descriptors.find(
                                ({ value }) => value === formData?.incident_type
                            )?.name ?? descriptors[0].name
                        }
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        onChange={(e) => {
                            setFormData((prev) => ({
                                ...prev,
                                incident_type: descriptors.find(
                                    ({ name }) => name === e.target.value
                                )?.value,
                            }));
                        }}
                    >
                        {descriptors.map(({ name }, index) => (
                            <option key={index}>{name}</option>
                        ))}
                    </select>
                </div>
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Incident Descriptor
                    </label>
                </div>
                <div className="mt-1 grid grid-cols-1">
                    <select
                        value={formData.descriptor}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                descriptor: e.target.value,
                            }))
                        }
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    >
                        {descriptors.map(({ options, value }) =>
                            value === formData.incident_type && (
                                options.map((option, index) => (
                                    <option key={index}>{option}</option>
                                ))
                            )
                        )}
                    </select>
                </div>
            </div>

            {formData.descriptor === 'Other' && (
                <div className="mt-4">
                    <div>
                        <label className="block text-sm/6 font-medium text-gray-900">
                            Please briefly Describe:
                        </label>
                    </div>
                    <div className="mt-1">
                        <input
                            required
                            value={formData.other_descriptor ?? ''}
                            onChange={(e) =>
                                setFormData((prev) => ({
                                    ...prev,
                                    other_descriptor: e.target.value,
                                }))
                            }
                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>
            )}
        </div>
    );
}
