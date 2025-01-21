import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import { useState } from 'react';

export default function VictimInformationStage({
    formData,
    setFormData,
}: StageProps) {
    const [hasInjury, setHasInjury] = useState<boolean>(false);
    const [firstAidApplied, setFirstAidApplied] = useState<boolean>(false);

    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Victim Information
            </label>
            <div className="flex">
                <div className="min-w-0 flex-1 text-sm/6">
                    <label className="font-medium text-gray-900">Injury</label>
                    <p className="text-xs text-gray-500">
                        Did the incident result in an injury to the victim?
                    </p>
                </div>
                <div className="flex h-6 shrink-0 items-center">
                    <div className="group grid size-4 grid-cols-1">
                        <input
                            type="checkbox"
                            aria-describedby="was_injured-description"
                            checked={hasInjury}
                            onChange={(e) => setHasInjury(e.target.checked)}
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
            {hasInjury && (
                <>
                    <div>
                        <div className="flex items-center justify-between">
                            <label
                                htmlFor="injury_description"
                                className="block text-xs/6 font-medium text-gray-900"
                            >
                                Please describe the injury
                            </label>
                        </div>
                        <div className="mt-2">
                            <input
                                required
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
                    <div className="flex">
                        <div className="min-w-0 flex-1 text-sm/6">
                            <label
                                htmlFor="fa_applied"
                                className="font-medium text-gray-900"
                            >
                                Was first aid applied?
                            </label>
                        </div>
                        <div className="flex h-6 shrink-0 items-center">
                            <div className="group grid size-4 grid-cols-1">
                                <input
                                    id="fa_applied"
                                    name="fa_applied"
                                    type="checkbox"
                                    checked={firstAidApplied ?? false}
                                    onChange={(e) =>
                                        setFirstAidApplied(e.target.checked)
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
                    {firstAidApplied && (
                        <div>
                            <div className="flex items-center justify-between">
                                <label className="block text-xs/6 font-medium text-gray-900">
                                    Please describe the First Aid application.
                                </label>
                            </div>
                            <div className="mt-2">
                                <input
                                    required
                                    value={formData.first_aid_description ?? ''}
                                    onChange={(e) =>
                                        setFormData((prev) => ({
                                            ...prev,
                                            first_aid_description:
                                                e.target.value,
                                        }))
                                    }
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                            </div>
                        </div>
                    )}
                </>
            )}
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    General Incident Description
                </label>
                <p className="text-xs text-gray-500">
                    Please offer as in-depth a description as possible.
                </p>
                <div className="mt-2">
                    <textarea
                        id="description"
                        name="description"
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
