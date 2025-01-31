import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React from 'react';
import ToggleSwitch from '@/Components/ToggleSwitch';
import { isValidEmail } from '@/Filters/isValidEmail';
import { usePage } from '@inertiajs/react';

export default function AnonymousStage({
    formData,
    setFormData,
    failedStep,
    setValidStep,
}: StageProps) {
    const { auth } = usePage().props;

    return (
        <div className="flex-1 space-y-4 divide-y">
            <div>
                <div className="flex-row text-center">
                    <div className="min-w-0 flex-1 text-sm/6">
                        <label className="font-medium text-gray-900">
                            Would you as the reporter like to remain anonymous?
                        </label>
                    </div>

                    <ToggleSwitch
                        checked={formData.anonymous ?? false}
                        onChange={(e) => {
                            setFormData('anonymous', e.valueOf());

                            if (!e.valueOf() && auth.user) {
                                setFormData('reporters_email', auth.user.email);
                                setValidStep(true);
                            } else if (
                                (formData.reporters_email === '' ||
                                    isValidEmail(
                                        formData.reporters_email ?? ''
                                    )) &&
                                !e.valueOf()
                            ) {
                                setValidStep(false);
                            } else {
                                setValidStep(true);
                            }
                        }}
                    />
                </div>

                {!formData.anonymous && (
                    <div>
                        <label
                            htmlFor="email"
                            className="block text-sm/6 font-medium text-gray-900"
                        >
                            Reporter's Email
                        </label>
                        <div className="mt-2">
                            <input
                                type="email"
                                disabled={auth.user !== null}
                                value={
                                    auth.user
                                        ? auth.user.email
                                        : (formData.reporters_email ?? '')
                                }
                                onChange={(e) => {
                                    setFormData(
                                        'reporters_email',
                                        e.target.value
                                    );
                                    if (
                                        e.target.value !== '' &&
                                        isValidEmail(e.target.value)
                                    ) {
                                        setValidStep(true);
                                    } else {
                                        setValidStep(false);
                                    }
                                }}
                                placeholder="example@email.com"
                                className="block disabled:opacity-60 w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                            {failedStep && (
                                <p
                                    id="validation-error"
                                    className="mt-2 text-sm text-red-600"
                                >
                                    *Please enter a valid email
                                </p>
                            )}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
