import { ChevronDownIcon } from '@heroicons/react/16/solid';
import React, { useState, useEffect, ChangeEvent } from 'react';
import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import IncidentData from '@/types/IncidentData';

const categories = [
    {
        name: 'Safety',
        value: 1,
        options: [
            'Injury',
            'Illness',
            'Exposure',
            'Animal bite/sting/scratch',
            'Needle/sharp/puncture/cut',
            'Slip/Trip/fall',
            'Burn/Shock',
            'Sexual Harassment',
            'Personal Harassment',
            'Discrimination',
            'Near Miss/Hazard',
            'Other',
        ],
    },
    {
        name: 'Security',
        value: 2,
        options: [
            'Lab Bio security incident/threat',
            'Theft/Assault',
            'Bomb threat',
            'Violent Threat/Harassment',
            'Property damage/Equipment Loss',
            'Suspicious Activity',
            'Near Miss/Hazard',
            'Other',
        ],
    },
    {
        name: 'Environmental',
        value: 3,
        options: [
            'Spill',
            'Hazardous Materials',
            'Fire',
            'Infectious Materials',
            'Air/Water pollution',
            'Near Miss/Hazard',
            'Other',
        ],
    },
];

export default function IncidentInformationStage({
    formData,
    setFormData,
}: StageProps) {
    const [currentCategory, setCurrentCategory] = useState(categories[0].name);

    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Incident Information
            </label>

            <div>
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
                    <div className="flex h-6 shrink-0 items-center">
                        <div className="group grid size-4 grid-cols-1">
                            <input
                                type="checkbox"
                                aria-describedby="work_related-description"
                                checked={formData.work_related ?? false}
                                onChange={(e) =>
                                    setFormData((prev) => ({
                                        ...prev,
                                        work_related: e.target.checked,
                                    }))
                                }
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
                <label className="block text-sm/6 font-medium text-gray-900">
                    Location
                </label>
                <p className="text-xs text-gray-500">
                    Enter the building or description of area where the incident
                    occurred.
                </p>
                <div className="mt-2">
                    <input
                        aria-describedby="location-description"
                        required
                        value={formData.location ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                location: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>

            <div>
                <div className="flex items-center justify-between">
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Room Number
                    </label>
                </div>
                <p className="text-xs text-gray-500">If Applicable.</p>

                <div className="mt-2">
                    <input
                        required
                        value={formData.room_number ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                room_number: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Incident Type
                </label>
                <div className="mt-2 grid grid-cols-1">
                    <select
                        defaultValue={currentCategory ?? categories[0].name}
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        onChange={() => {}}
                    >
                        {categories.map(({ name, value }, index) => (
                            <option
                                key={name}
                                onClick={(_) => {
                                    setFormData((prev) => ({
                                        ...prev,
                                        incident_type: value,
                                    }));
                                    setCurrentCategory(name);
                                }}
                            >
                                {name}
                            </option>
                        ))}
                    </select>
                </div>
            </div>
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Incident Descriptor
                </label>
                <div className="mt-2 grid grid-cols-1">
                    <select
                        defaultValue={
                            formData.descriptor ??
                            categories.find(
                                (category) => category.name === currentCategory
                            )?.options[0] ??
                            ''
                        }
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                descriptor: e.target.value,
                            }))
                        }
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    >
                        {categories.map(({ name, options }, index) =>
                            name === currentCategory ? (
                                options.map((option) => (
                                    <option key={option}>{option}</option>
                                ))
                            ) : (
                                <></>
                            )
                        )}
                    </select>
                </div>
            </div>
            {formData.descriptor === 'Other' && (
                <div>
                    <div className="flex items-center justify-between">
                        <label className="block text-sm/6 font-medium text-gray-900">
                            Please briefly Describe:
                        </label>
                    </div>
                    <div className="mt-2">
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
