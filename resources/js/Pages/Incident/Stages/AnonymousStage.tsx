import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React from 'react';
import ToggleSwitch from "@/Components/ToggleSwitch";



export default function AnonymousStage({ formData, setFormData }: StageProps) {
    return (
        <div className="flex-1 space-y-4 divide-y">
            <div>
                <div className="flex-row text-center">
                    <div className="min-w-0 flex-1 text-sm/6">
                        <label className="font-medium text-gray-900">
                            Would you like to remain anonymous?
                        </label>
                    </div>

                    <ToggleSwitch
                        checked={formData.anonymous}
                        onChange={(e) => {
                            setFormData((prev) => ({
                                ...prev,
                                anonymous: e.valueOf(),
                            }));
                        }}
                    />
                </div>

                {!formData.anonymous && (
                    <div>
                        <label
                            htmlFor="email"
                            className="block text-sm/6 font-medium text-gray-900"
                        >
                            Email
                        </label>
                        <div className="mt-2">
                            <input
                                type="email"
                                value={formData.reporters_email ?? ''}
                                onChange={(e) =>
                                    setFormData((prev) => ({
                                        ...prev,
                                        reporters_email: e.target.value,
                                    }))
                                }
                                placeholder="example@email.com"
                                className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
