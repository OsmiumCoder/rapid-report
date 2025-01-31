import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React, { useState } from 'react';
import { Witness } from '@/types/incident/Witness';
import { PlusIcon } from '@heroicons/react/20/solid';
import WitnessList from '@/Components/WitnessList';
import validatePhoneInput from '@/Filters/validatePhoneInput';
import { isValidEmail } from '@/Filters/isValidEmail';

const newWitness: () => Witness = () => ({
    name: '',
    email: '',
    phone: '',
});

export default function WitnessStage({
    formData,
    setFormData,
    setShowButtons,
}: StageProps) {
    const [witnessInProgress, setWitnessInProgress] = useState(newWitness());
    const [validationError, setValidationError] = useState(false);
    const [witnessFormVisible, setWitnessFormVisible] = useState(false);

    const addPerson = () => {
        if (witnessInProgress.name.length === 0) {
            return setValidationError(true);
        }

        setValidationError(false);
        setFormData('witnesses', [
            ...(formData.witnesses ?? []),
            witnessInProgress,
        ]);
        setWitnessInProgress(newWitness());
        setShowButtons((prev) => !prev);
        setWitnessFormVisible((prev) => !prev);
    };
    const removePerson = (index: number) => {
        setFormData(
            'witnesses',
            formData.witnesses
                ? formData.witnesses.filter(
                      (_, personIndex) => personIndex != index
                  )
                : []
        );
    };

    return (
        <div className="min-w-0 flex-1 text-sm/6 space-y-4">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Witnesses
            </label>

            {witnessFormVisible && (
                <>
                    <div>
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Witness Name
                            </label>
                            <div className="mt-2">
                                <input
                                    value={witnessInProgress.name}
                                    onChange={(e) => {
                                        setWitnessInProgress((prev) => ({
                                            ...prev,
                                            name: e.target.value,
                                        }));
                                    }}
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                                {validationError && (
                                    <span className="text-red-600">
                                        Name is Required
                                    </span>
                                )}
                            </div>
                        </div>
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Witness Email
                            </label>
                            <div className="mt-2">
                                <input
                                    type="email"
                                    value={witnessInProgress.email}
                                    onChange={(e) => {
                                        setWitnessInProgress((prev) => ({
                                            ...prev,
                                            email: e.target.value,
                                        }));
                                    }}
                                    placeholder="you@example.com"
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />

                                {witnessInProgress.email.length > 0 &&
                                    !isValidEmail(witnessInProgress.email) && (
                                        <p className="mt-2 text-sm text-red-600">
                                            Invalid Email Address
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
                                    value={witnessInProgress.phone ?? ''}
                                    onChange={(e) =>
                                        setWitnessInProgress((prev) => ({
                                            ...prev,
                                            phone: validatePhoneInput(
                                                e.target.value
                                            ),
                                        }))
                                    }
                                    className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                />
                                {witnessInProgress.phone.length > 0 &&
                                    witnessInProgress.phone.length < 12 && (
                                        <p className="mt-2 text-sm text-red-600">
                                            Invalid Phone Number
                                        </p>
                                    )}
                            </div>
                        </div>
                    </div>
                    <div className="flex justify-between mx-5">
                        <button
                            type="button"
                            onClick={() => {
                                setWitnessFormVisible((prev) => !prev);
                                setShowButtons((prev) => !prev);
                            }}
                            className="mr-16 pr-3 items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Cancel
                        </button>
                        <button
                            type="button"
                            onClick={addPerson}
                            className="items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Add Witness
                        </button>
                    </div>
                    {validationError && (
                        <p className="mt-2 text-sm text-red-600">
                            *More Information Required
                        </p>
                    )}
                </>
            )}
            {!witnessFormVisible && (
                <>
                    <WitnessList
                        removeWitness={removePerson}
                        witnesses={formData.witnesses ?? []}
                    />
                    <div className="flex justify-center">
                        <button
                            type="button"
                            onClick={() => {
                                setWitnessFormVisible((prev) => !prev);
                                setShowButtons((prev) => !prev);
                            }}
                            className="my-2 flex justify-center items-center gap-x-2 rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Add a Witness
                            <PlusIcon aria-hidden="true" className="size-3" />
                        </button>
                    </div>
                </>
            )}
        </div>
    );
}
