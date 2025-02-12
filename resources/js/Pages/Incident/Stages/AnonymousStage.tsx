import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React from 'react';
import ToggleSwitch from '@/Components/ToggleSwitch';
import { isValidEmail } from '@/Filters/isValidEmail';
import { usePage } from '@inertiajs/react';
import TextInput from '@/Components/TextInput';

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
                                    isValidEmail(formData.reporters_email ?? '')) &&
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
                            <TextInput
                                type="email"
                                disabled={auth.user !== null}
                                value={
                                    auth.user ? auth.user.email : (formData.reporters_email ?? '')
                                }
                                onChange={(e) => {
                                    setFormData('reporters_email', e.target.value);
                                    if (e.target.value !== '' && isValidEmail(e.target.value)) {
                                        setValidStep(true);
                                    } else {
                                        setValidStep(false);
                                    }
                                }}
                                placeholder="example@email.com"
                            />
                            {failedStep && (
                                <p id="validation-error" className="mt-2 text-sm text-red-600">
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
