import { InvestigationComponentProps } from '@/Pages/Investigation/Create';
import TextArea from '@/Components/TextArea';
import React from 'react';
import InputError from '@/Components/InputError';
import {
    energyTransferCauses,
    jobFactors,
    personalFactors,
    substandardActs,
    substandardConditions,
} from '@/Pages/Investigation/Partials/createDropdownValues';
import LabeledCheckbox from '@/Components/LabeledCheckbox';

export default function Causes({
    formData,
    setFormData,
    errors,
    toggleCheckbox,
}: InvestigationComponentProps) {
    return (
        <>
            <div className="mb-4">
                <label className="font-semibold text-gray-700">Immediate Causes:</label>
                <p className="text-sm text-gray-600 italic">
                    What substandard acts/practices and conditions caused or could cause the event?
                </p>
                <TextArea
                    value={formData.immediate_causes}
                    onChange={(e) => setFormData('immediate_causes', e.target.value)}
                    className="p-2 border border-gray-300 rounded-md "
                />
            </div>
            <InputError message={errors?.immediate_causes} />

            <div className="mb-4">
                <label className="font-semibold text-gray-700">Basic Causes:</label>
                <p className="text-sm text-gray-600 italic">
                    What specific personal or job/system factors caused or could cause this event?
                </p>
                <TextArea
                    value={formData.basic_causes}
                    onChange={(e) => setFormData('basic_causes', e.target.value)}
                    className="p-2 border border-gray-300 rounded-md"
                />
            </div>

            <InputError message={errors?.basic_causes} />

            <div className="mb-4">
                <label className="font-semibold text-gray-700">Remedial Actions:</label>
                <p className="text-sm text-gray-600 italic">
                    What has and/or should be done to control the causes listed?
                </p>
                <TextArea
                    value={formData.remedial_actions}
                    onChange={(e) => setFormData('remedial_actions', e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full"
                />
            </div>
            <InputError message={errors?.remedial_actions} />

            <h3 className="text-lg font-semibold text-gray-700 mt-6">Prevention of Recurrence</h3>
            <div className="mb-4">
                <label className="text-gray-700">Prevention Measures:</label>
                <p className="text-sm text-gray-600 italic">
                    Describe what action is planned or has been taken to prevent a recurrence of the
                    incident, based on the key contributing factors (both immediate and long term).
                </p>
                <TextArea
                    value={formData.prevention}
                    onChange={(e) => setFormData('prevention', e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full"
                />
            </div>
            <InputError message={errors?.prevention} />

            <fieldset className="mb-4">
                <legend className="font-semibold text-gray-700 mb-2">
                    Substandard Acts & Conditions:
                </legend>
                <div className="grid grid-cols-2 ">
                    <div>
                        <h4 className="text-gray-600 font-semibold mb-2">Substandard Acts</h4>
                        {substandardActs.map((cause) => (
                            <LabeledCheckbox
                                key={cause}
                                label={cause}
                                value={cause}
                                checked={formData.substandard_acts.includes(cause)}
                                onChange={() => toggleCheckbox('substandard_acts', cause)}
                                className="mr-2"
                            />
                        ))}
                    </div>
                    <InputError message={errors?.substandard_acts} />

                    <div>
                        <h4 className="text-gray-600 font-semibold mb-2">Substandard Conditions</h4>
                        {substandardConditions.map((condition) => (
                            <LabeledCheckbox
                                key={condition}
                                label={condition}
                                value={condition}
                                checked={formData.substandard_conditions.includes(condition)}
                                onChange={() => toggleCheckbox('substandard_conditions', condition)}
                                className="mr-2"
                            />
                        ))}
                    </div>
                    <InputError message={errors?.substandard_acts} />
                </div>
            </fieldset>

            <fieldset className="mb-4">
                <legend className="font-semibold text-gray-700 mb-2">
                    Energy transfer or contact with a hazardous subject:
                </legend>
                <div className="grid grid-cols-1">
                    {energyTransferCauses.map((cause) => (
                        <LabeledCheckbox
                            key={cause}
                            label={cause}
                            value={cause}
                            checked={formData.energy_transfer_causes.includes(cause)}
                            onChange={() => toggleCheckbox('energy_transfer_causes', cause)}
                            className="mr-2"
                        />
                    ))}
                </div>
                <InputError message={errors?.energy_transfer_causes} />
            </fieldset>

            <fieldset className="mb-4">
                <legend className="font-semibold text-gray-700 mb-2">
                    Basic/Root Causes – check all as appropriate
                </legend>
                <div className="grid grid-cols-2 ">
                    <div>
                        <h4 className="text-gray-600 font-semibold mb-2">Personal factors</h4>
                        {personalFactors.map((cause) => (
                            <LabeledCheckbox
                                key={cause}
                                label={cause}
                                value={cause}
                                checked={formData.personal_factors.includes(cause)}
                                onChange={() => toggleCheckbox('personal_factors', cause)}
                                className="mr-2"
                            />
                        ))}
                    </div>
                    <InputError message={errors?.personal_factors} />

                    <div>
                        <h4 className="text-gray-600 font-semibold mb-2">Job factors</h4>
                        {jobFactors.map((cause) => (
                            <LabeledCheckbox
                                key={cause}
                                label={cause}
                                value={cause}
                                checked={formData.job_factors.includes(cause)}
                                onChange={() => toggleCheckbox('job_factors', cause)}
                                className="mr-2"
                            />
                        ))}
                        <InputError message={errors?.job_factors} />
                    </div>
                </div>
            </fieldset>
        </>
    );
}
