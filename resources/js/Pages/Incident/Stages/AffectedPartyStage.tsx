import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import { roles } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import React, { useEffect } from 'react';
import ToggleSwitch from '@/Components/ToggleSwitch';
import validatePhoneInput from '@/Filters/validatePhoneInput';
import { usePage } from '@inertiajs/react';

export default function AffectedPartyStage({
    formData,
    setFormData,
    failedStep,
    setValidStep,
}: StageProps) {
    const { auth } = usePage().props;

    useEffect(() => {
        handleValidStep();
    });

    useEffect(() => {
        if (!formData.on_behalf && auth.user) {
        }
    }, [formData.on_behalf]);

    const handleValidStep = () => {
        if (!formData.anonymous && !formData.on_behalf) {
            setValidStep(checkForm);
        } else if (formData.on_behalf && !formData.on_behalf_anonymous) {
            setValidStep(checkForm);
        } else {
            setValidStep(true);
        }
    };

    function checkForm() {
        return !(
            formData.first_name == '' ||
            formData.last_name == '' ||
            (formData.phone == '' && formData.email == '')
        );
    }

    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <div>
                <div className="flex-row text-center">
                    <div className="min-w-0 flex-1 text-sm/6">
                        <label className="font-medium text-gray-900">
                            Are you reporting on behalf of someone else?
                        </label>
                    </div>
                    <ToggleSwitch
                        checked={formData.on_behalf}
                        onChange={(e) => {
                            setFormData('on_behalf', e.valueOf());

                            if (!e.valueOf()) {
                                setFormData('email', formData.reporters_email);
                            }
                            handleValidStep();
                        }}
                    />
                </div>
            </div>

            {formData.on_behalf && (
                <>
                    <div>
                        <div className="flex-row text-center">
                            <div className="min-w-0 flex-1 text-sm/6">
                                <label
                                    htmlFor="onbehalf_anon"
                                    className="font-medium text-gray-900"
                                >
                                    Would the person you are reporting on behalf
                                    of like to remain anonymous?
                                </label>
                            </div>
                            <ToggleSwitch
                                checked={formData.on_behalf_anonymous}
                                onChange={(e) => {
                                    if (!e.valueOf) {
                                        setFormData('email', '');
                                    }
                                    setFormData(
                                        'on_behalf_anonymous',
                                        e.valueOf()
                                    );
                                    handleValidStep();
                                }}
                            />
                        </div>
                    </div>
                </>
            )}

            {((!formData.anonymous && !formData.on_behalf) ||
                (!formData.anonymous &&
                    formData.on_behalf &&
                    !formData.on_behalf_anonymous) ||
                (formData.anonymous &&
                    formData.on_behalf &&
                    !formData.on_behalf_anonymous)) && (
                <>
                    <label className="flex justify-center font-bold text-lg text-gray-900">
                        Affected Party Information
                    </label>

                    <div className="mt-2">
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                First Name
                            </label>
                        </div>

                        <div className="mt-1">
                            <input
                                required
                                value={formData.first_name ?? ''}
                                onChange={(e) => {
                                    setFormData('first_name', e.target.value);
                                    handleValidStep();
                                }}
                                className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                            {failedStep && formData.first_name == '' && (
                                <p
                                    id="validation-error"
                                    className="mt-2 text-sm text-red-600"
                                >
                                    *Please enter the affected individuals first
                                    name
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="mt-2">
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Last Name
                            </label>
                        </div>

                        <div className="mt-1">
                            <input
                                required
                                value={formData.last_name ?? ''}
                                onChange={(e) => {
                                    setFormData('last_name', e.target.value);
                                    handleValidStep();
                                }}
                                className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                            {failedStep && formData.last_name == '' && (
                                <p
                                    id="validation-error"
                                    className="mt-2 text-sm text-red-600"
                                >
                                    *Please enter the affected individuals last
                                    name
                                </p>
                            )}
                        </div>
                    </div>

                    <div className="mt-2">
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Phone Number
                            </label>
                        </div>

                        <div className="mt-1">
                            <input
                                required
                                type="tel"
                                placeholder="123-456-7890"
                                value={formData.phone ?? ''}
                                onChange={(e) => {
                                    setFormData(
                                        'phone',
                                        validatePhoneInput(e.target.value)
                                    );
                                    handleValidStep();
                                }}
                                className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                    </div>

                    <div className="mt-2">
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Email
                            </label>
                        </div>

                        <div className="mt-1">
                            <input
                                required
                                type="email"
                                placeholder="name@example.com"
                                value={formData.email ?? ''}
                                onChange={(e) => {
                                    setFormData('email', e.target.value);
                                    handleValidStep();
                                }}
                                className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                            {failedStep &&
                                formData.phone == '' &&
                                formData.email == '' && (
                                    <p
                                        id="validation-error"
                                        className="mt-2 text-sm text-red-600"
                                    >
                                        *Please enter at least a phone number or
                                        email
                                    </p>
                                )}
                        </div>
                    </div>

                    <div className="mt-2">
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Incident Role
                            </label>
                        </div>

                        <div className="mt-1 grid grid-cols-1">
                            <select
                                value={
                                    roles.find(
                                        ({ value }) => value === formData?.role
                                    )?.name ?? roles[0].name
                                }
                                onChange={(e) =>
                                    setFormData(
                                        'role',
                                        roles.find(
                                            ({ name }) =>
                                                name === e.target.value
                                        )?.value
                                    )
                                }
                                className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            >
                                {roles.map(({ name }, index) => (
                                    <option key={index}>{name}</option>
                                ))}
                            </select>
                        </div>
                    </div>

                    {(formData.role === 1 || formData.role === 2) && (
                        <div className="mt-2">
                            <div>
                                <label className="block text-sm/6 font-medium text-gray-900">
                                    UPEI ID
                                </label>
                            </div>

                            <div className="mt-1">
                                <input
                                    required
                                    value={formData.upei_id ?? ''}
                                    onChange={(e) =>
                                        setFormData('upei_id', e.target.value)
                                    }
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                            </div>
                        </div>
                    )}
                </>
            )}
        </div>
    );
}
