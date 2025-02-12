import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import React, { useState } from 'react';
import { Witness } from '@/types/incident/Witness';
import { PlusIcon } from '@heroicons/react/20/solid';
import WitnessList from '@/Components/WitnessList';
import validatePhoneInput from '@/Filters/validatePhoneInput';
import { isValidEmail } from '@/Filters/isValidEmail';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import TextInput from '@/Components/TextInput';
import TextArea from '@/Components/TextArea';

const newWitness: () => Witness = () => ({
    name: '',
    email: '',
    phone: '',
});

export default function WitnessStage({ formData, setFormData, setShowButtons }: StageProps) {
    const [witnessInProgress, setWitnessInProgress] = useState(newWitness());
    const [validationError, setValidationError] = useState(false);
    const [witnessFormVisible, setWitnessFormVisible] = useState(false);

    const addPerson = () => {
        if (witnessInProgress.name.length === 0) {
            return setValidationError(true);
        }

        setValidationError(false);
        setFormData('witnesses', [...(formData.witnesses ?? []), witnessInProgress]);
        setWitnessInProgress(newWitness());
        setShowButtons?.((prev) => !prev);
        setWitnessFormVisible((prev) => !prev);
    };
    const removePerson = (index: number) => {
        setFormData(
            'witnesses',
            formData.witnesses
                ? formData.witnesses.filter((_, personIndex) => personIndex != index)
                : []
        );
    };

    return (
        <div className="min-w-0 flex-1 text-sm/6 space-y-4">
            <label className="flex justify-center font-bold text-lg text-gray-900">Witnesses</label>

            {witnessFormVisible && (
                <>
                    <div>
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Witness Name
                            </label>
                            <div className="mt-2">
                                <TextInput
                                    value={witnessInProgress.name}
                                    onChange={(e) => {
                                        setWitnessInProgress((prev) => ({
                                            ...prev,
                                            name: e.target.value,
                                        }));
                                    }}
                                />
                                {validationError && (
                                    <span className="text-red-600">Name is Required</span>
                                )}
                            </div>
                        </div>
                        <div>
                            <label className="block text-sm/6 font-medium text-gray-900">
                                Witness Email
                            </label>
                            <div className="mt-2">
                                <TextInput
                                    type="email"
                                    value={witnessInProgress.email}
                                    onChange={(e) => {
                                        setWitnessInProgress((prev) => ({
                                            ...prev,
                                            email: e.target.value,
                                        }));
                                    }}
                                    placeholder="you@example.com"
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
                                <TextInput
                                    required
                                    type="tel"
                                    placeholder="123-456-7890"
                                    value={witnessInProgress.phone ?? ''}
                                    onChange={(e) =>
                                        setWitnessInProgress((prev) => ({
                                            ...prev,
                                            phone: validatePhoneInput(e.target.value),
                                        }))
                                    }
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
                        <DangerButton
                            type="button"
                            onClick={() => {
                                setWitnessFormVisible((prev) => !prev);
                                setShowButtons?.((prev) => !prev);
                            }}
                            className="mr-16 pr-3 items-center gap-x-2 rounded-md  px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 "
                        >
                            Cancel
                        </DangerButton>
                        <PrimaryButton
                            type="button"
                            onClick={addPerson}
                            className="items-center gap-x-2 rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 "
                        >
                            Add Witness
                        </PrimaryButton>
                    </div>
                    {validationError && (
                        <p className="mt-2 text-sm text-red-600">*More Information Required</p>
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
                        <PrimaryButton
                            type="button"
                            onClick={() => {
                                setWitnessFormVisible((prev) => !prev);
                                setShowButtons?.((prev) => !prev);
                            }}
                            className="my-2 flex justify-center items-center gap-x-2 rounded-md px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm  focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            Add a Witness
                            <PlusIcon aria-hidden="true" className="size-3" />
                        </PrimaryButton>
                    </div>
                </>
            )}
        </div>
    );
}
