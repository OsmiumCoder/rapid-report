import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React, { useState } from 'react';
import ToggleSwitch from "@/Components/ToggleSwitch";

export default function VictimInformationStage({
    formData,
    setFormData,
}: StageProps) {
    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Victim Information
            </label>

            <div className="flex">
                <div className="min-w-0 flex-1 text-sm/6">
                    <label className="font-medium text-gray-900">Injury</label>
                    <p className="text-xs text-gray-500">
                        Did the incident result in injury?
                    </p>
                </div>
                <ToggleSwitch
                    checked={formData.has_injury ?? false}
                    onChange={(e) => {
                        setFormData((prev) => ({
                            ...prev,
                            has_injury: e.valueOf(),
                        }));
                    }}
                />
            </div>

            {formData.has_injury && (
                <div className="mt-2">
                    <div>
                        <label className="block text-sm/6 font-medium text-gray-900">
                            Please describe the injury that occured.
                        </label>
                    </div>
                    <div className="mt-1">
                        <textarea
                            rows={4}
                            value={formData.injury_description ?? ''}
                            onChange={(e) =>
                                setFormData((prev) => ({
                                    ...prev,
                                    injury_description: e.target.value,
                                }))
                            }
                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>
            )}

            <div className="flex mt-4">
                <div className="min-w-0 flex-1 text-sm/6">
                    <label className="block text-sm/6 font-medium text-gray-900">
                        First Aid
                    </label>
                    <p className="text-xs text-gray-500">
                        Did the incident result in an first aid being required?
                    </p>
                </div>
                <ToggleSwitch
                    checked={formData.first_aid_applied ?? false}
                    onChange={(e) => {
                        setFormData((prev) => ({
                            ...prev,
                            first_aid_applied: e.valueOf(),
                        }));
                    }}
                />
            </div>
            {formData.first_aid_applied && (
                <div className="mt-2">
                    <div>
                        <label className="block text-sm/6 font-medium text-gray-900">
                            Please describe the First Aid that was required.
                        </label>
                    </div>
                    <div className="mt-1">
                        <textarea
                            rows={4}
                            value={formData.first_aid_description ?? ''}
                            onChange={(e) =>
                                setFormData((prev) => ({
                                    ...prev,
                                    first_aid_description: e.target.value,
                                }))
                            }
                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        />
                    </div>
                </div>
            )}

            <div className="mt-4">
                <label className="block text-sm/6 font-medium text-gray-900">
                    General Description
                </label>
                <p className="text-xs text-gray-500">
                    Please offer as in-depth a description as possible.
                </p>
                <div className="mt-2">
                    <textarea
                        rows={4}
                        value={formData.description ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                description: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
        </div>
    );
}
