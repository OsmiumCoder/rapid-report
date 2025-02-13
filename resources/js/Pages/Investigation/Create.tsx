import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm, usePage } from '@inertiajs/react';
import React, { FormEvent } from 'react';
import TextArea from '@/Components/TextArea';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import { InformationCircleIcon } from '@heroicons/react/24/outline';
import Modal from '@/Components/Modal';
import SelectInput from '@/Components/SelectInput';
import PrimaryButton from '@/Components/PrimaryButton';
import { Incident } from '@/types/incident/Incident';

const resultedIn = [
    'Injury',
    'Illness',
    'Property damage',
    'Near miss',
    'First aid',
    'Medical aid',
    'Recurrence',
    'Other',
];

const substandardActs = [
    'Operating equipment without authority',
    'Failure to warn',
    'Failure to secure',
    'Operating at improper speed',
    'Making safety devices inoperable',
    'Removing safety devices',
    'Using defective equipment',
    'Failure to use personal protective equipment (PPE)',
    'Improper loading',
];

const substandardConditions = [
    'Fire and explosion hazard',
    'Lack of guard or barrier',
    'Inadequate or improper protective equipment',
    'Defective tools, equipment or materials',
    'Restricted space',
    'Inadequate warning system',
    'Poor housekeeping',
    'Hazardous environmental conditions (gases, dusts,' + 'fumes, vapours, etc.)',
    'Radiation exposure',
    'High or low temperature exposure',
    'Inadequate or excess illumination',
    'Inadequate ventilation',
];

const energyTransferCauses = [
    'Struck by (stationary or moving object)',
    'Struck against (ran or bumped into an object)',
    'Came into contact with (electricity, heat, cold, radiation, toxins, noise, caustics, etc.)',
    'Caught in or between (pinch or nip points, crushing or shearing)',
    'Caught on (snagged or hanging)',
    'Fall on the same level (slip, trip, or fall)',
    'Fall to lower level',
    'Exposure',
    'Overexertion',
    'Repetitive action',
];

const personalFactors = [
    'Inadequate capacity',
    'Lack of knowledge/training',
    'Lack of skill',
    'Stress',
    'Improper motivation',
];

const jobFactors = [
    'Inadequate leadership/supervision',
    'Inadequate engineering',
    'Inadequate purchasing',
    'Inadequate maintenance',
    'Inadequate tools/equipment',
    'Inadequate work standards',
    'Wear and tear',
    'Abuse and/or misuse',
];
export default function Create({ incident }: { incident: Incident }) {
    const [isModalOpen, setIsModalOpen] = React.useState(false);
    const { data, setData, post } = useForm({
        immediate_causes: '',
        basic_causes: '',
        remedial_actions: '',
        prevention: '',
        risk_rank: 1,
        resulted_in: [] as string[],
        substandard_acts: [] as string[],
        substandard_conditions: [] as string[],
        energy_transfer_causes: [] as string[],
        personal_factors: [] as string[],
        job_factors: [] as string[],
    });

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route('incidents.investigations.store', { incident: incident.id }));
    };

    const toggleCheckbox = (category: keyof typeof data, value: string) => {
        const updatedList = (data[category] as string[]).includes(value)
            ? (data[category] as string[]).filter((item) => item !== value)
            : [...(data[category] as string[]), value];
        setData(category, updatedList as never[]);
    };

    return (
        <AuthenticatedLayout>
            <Head title="New Investigation" />
            <form
                onSubmit={handleSubmit}
                className="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md"
            >
                <h2 className="text-xl font-bold mb-4">Incident Investigation Form</h2>

                <fieldset className="mb-4">
                    <legend className="font-semibold text-gray-700 mb-2">
                        Incident Resulted In:
                    </legend>
                    <div className="grid grid-cols-2">
                        {resultedIn.map((result) => (
                            <LabeledCheckbox
                                key={result}
                                label={result}
                                value={result}
                                checked={data.resulted_in.includes(result)}
                                onChange={() => toggleCheckbox('resulted_in', result)}
                                className="mr-2"
                            />
                        ))}
                    </div>
                </fieldset>

                <div className="mb-4">
                    <label className="flex items-center text-gray-700">
                        Risk Ranking:
                        <InformationCircleIcon
                            onClick={() => setIsModalOpen(true)}
                            className="size-6 ml-2 hover:text-gray-400 hover:cursor-pointer "
                        />
                    </label>
                    <SelectInput
                        value={data.risk_rank}
                        onChange={(e) => setData('risk_rank', parseInt(e.target.value))}
                        className="p-2 border border-gray-300 rounded-md w-full"
                    >
                        {Array(9)
                            .fill(0)
                            .map((_, i) => (
                                <option key={i} value={i + 1}>
                                    {i + 1}
                                </option>
                            ))}
                    </SelectInput>
                </div>
                <Modal show={isModalOpen} onClose={() => setIsModalOpen(false)}>
                    <div className="p-4 flex flex-col justify-center items-center">
                        <h3 className="text-lg font-bold mb-2">
                            Three Point Risk Ranking Scheme and Ranking Matrix
                        </h3>


                            <table className=" border border-gray-300">
                                <thead>
                                <tr>
                                    <th
                                        rowSpan={2}
                                        className="border border-gray-300 px-4 py-2 text-center"
                                    >
                                        Frequency
                                    </th>
                                    <th
                                        colSpan={3}
                                        className="border border-gray-300 px-4 py-2 text-center"
                                    >
                                        Hazard Severity
                                    </th>
                                </tr>
                                <tr>
                                    <th className="border border-gray-300 px-4 py-2 text-center">
                                        Minor
                                    </th>
                                    <th className="border border-gray-300 px-4 py-2 text-center">
                                        Serious
                                    </th>
                                    <th className="border border-gray-300 px-4 py-2 text-center">
                                        Major
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2">Seldom</td>
                                    <td className="border-r border-b border-black px-4 py-2 bg-green-300 text-center">
                                        1
                                    </td>
                                    <td className="border-x border-b border-black px-4 py-2 bg-green-300 text-center">
                                        2
                                    </td>
                                    <td className="border-l border-b border-black px-4 py-2 bg-yellow-200 text-center">
                                        3
                                    </td>
                                </tr>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2">Occasional</td>
                                    <td className="border-y border-r border-black px-4 py-2 bg-green-300 text-center">
                                        2
                                    </td>
                                    <td className="border border-black px-4 py-2 bg-yellow-200 text-center">
                                        4
                                    </td>
                                    <td className="border-y border-l border-black px-4 py-2 bg-red-300 text-center">
                                        6
                                    </td>
                                </tr>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2">Frequent</td>
                                    <td className="border-t border-r border-black px-4 py-2 bg-yellow-200 text-center">
                                        3
                                    </td>
                                    <td className="border-t border-x border-black px-4 py-2 bg-red-300 text-center">
                                        6
                                    </td>
                                    <td className="border-t border-l border-black px-4 py-2 bg-red-300 text-center">
                                        9
                                    </td>
                                </tr>
                                </tbody>
                            </table>


                        <div className="flex flex-col md:flex-row mt-6 gap-4">
                            <table className="border border-gray-300 ">
                                <thead>
                                <tr>
                                    <th className="border border-gray-300 px-4 py-2 text-center">Level</th>
                                    <th className="border border-gray-300 px-4 py-2 text-center">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2 text-center">
                                        <strong>Minor</strong>
                                    </td>
                                    <td className="border border-gray-300 px-4 py-2">
                                        Low risk to students/staff/
                                        visitors/contractors/UPEI
                                    </td>
                                </tr>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2 text-center">
                                        <strong>Serious</strong>
                                    </td>
                                    <td className="border border-gray-300 px-4 py-2">
                                        Moderate risk to students/staff/
                                        visitors/contractors/UPEI
                                    </td>
                                </tr>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2 text-center">
                                        <strong>Major</strong>
                                    </td>
                                    <td className="border border-gray-300 px-4 py-2">
                                        High risk to students/staff/
                                        visitors/contractors/UPEI
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <table className="border border-gray-300 ">
                                <thead>
                                <tr>
                                    <th className="border border-gray-300 px-4 py-2 text-center">Level</th>
                                    <th className="border border-gray-300 px-4 py-2 text-center">Description</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2 text-center">
                                        <strong>Seldom</strong>
                                    </td>
                                    <td className="border border-gray-300 px-4 py-2">
                                        Very unlikely risk to
                                        students/staff/visitors/contractors/UPEI
                                    </td>
                                </tr>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2 text-center">
                                        <strong>Occasional</strong>
                                    </td>
                                    <td className="border border-gray-300 px-4 py-2">
                                        Risk to some students/staff/
                                        visitors/contractors during specific tasks or areas.
                                        Medium risk to UPEI.
                                    </td>
                                </tr>
                                <tr>
                                    <td className="border border-gray-300 px-4 py-2 text-center">
                                        <strong>Frequent</strong>
                                    </td>
                                    <td className="border border-gray-300 px-4 py-2">
                                        Students/staff/visitors/
                                        contractors/UPEI continuously exposed to the risk
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </Modal>


                <div className="mb-4">
                    <label className="font-semibold text-gray-700">Immediate Causes:</label>
                    <p className="text-sm text-gray-600 italic">
                        What substandard acts/practices and conditions caused or could cause the
                        event?
                    </p>
                    <TextArea
                        value={data.immediate_causes}
                        onChange={(e) => setData('immediate_causes', e.target.value)}
                        className="p-2 border border-gray-300 rounded-md "
                    />
                </div>

                <div className="mb-4">
                    <label className="font-semibold text-gray-700">Basic Causes:</label>
                    <p className="text-sm text-gray-600 italic">
                        What specific personal or job/system factors caused or could cause this
                        event?
                    </p>
                    <TextArea
                        value={data.basic_causes}
                        onChange={(e) => setData('basic_causes', e.target.value)}
                        className="p-2 border border-gray-300 rounded-md"
                    />
                </div>

                <div className="mb-4">
                    <label className="font-semibold text-gray-700">Remedial Actions:</label>
                    <p className="text-sm text-gray-600 italic">
                        What has and/or should be done to control the causes listed?
                    </p>
                    <TextArea
                        value={data.remedial_actions}
                        onChange={(e) => setData('remedial_actions', e.target.value)}
                        className="p-2 border border-gray-300 rounded-md w-full"
                    />
                </div>

                <h3 className="text-lg font-semibold text-gray-700 mt-6">
                    Prevention of Recurrence
                </h3>

                <div className="mb-4">
                    <label className="text-gray-700">Prevention Measures:</label>
                    <p className="text-sm text-gray-600 italic">
                        Describe what action is planned or has been taken to prevent a recurrence of
                        the incident, based on the key contributing factors (both immediate and long
                        term).
                    </p>
                    <TextArea
                        value={data.prevention}
                        onChange={(e) => setData('prevention', e.target.value)}
                        className="p-2 border border-gray-300 rounded-md w-full"
                    />
                </div>

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
                                    checked={data.substandard_acts.includes(cause)}
                                    onChange={() => toggleCheckbox('substandard_acts', cause)}
                                    className="mr-2"
                                />
                            ))}
                        </div>

                        <div>
                            <h4 className="text-gray-600 font-semibold mb-2">
                                Substandard Conditions
                            </h4>
                            {substandardConditions.map((condition) => (
                                <LabeledCheckbox
                                    key={condition}
                                    label={condition}
                                    value={condition}
                                    checked={data.substandard_conditions.includes(condition)}
                                    onChange={() =>
                                        toggleCheckbox('substandard_conditions', condition)
                                    }
                                    className="mr-2"
                                />
                            ))}
                        </div>
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
                                checked={data.energy_transfer_causes.includes(cause)}
                                onChange={() => toggleCheckbox('energy_transfer_causes', cause)}
                                className="mr-2"
                            />
                        ))}
                    </div>
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
                                    checked={data.personal_factors.includes(cause)}
                                    onChange={() => toggleCheckbox('personal_factors', cause)}
                                    className="mr-2"
                                />
                            ))}
                        </div>
                        <div>
                            <h4 className="text-gray-600 font-semibold mb-2">Job factors</h4>
                            {jobFactors.map((cause) => (
                                <LabeledCheckbox
                                    key={cause}
                                    label={cause}
                                    value={cause}
                                    checked={data.job_factors.includes(cause)}
                                    onChange={() => toggleCheckbox('job_factors', cause)}
                                    className="mr-2"
                                />
                            ))}
                        </div>
                    </div>
                </fieldset>

                <div className="flex justify-end mt-4">
                    <PrimaryButton
                        type="submit"
                        className="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
                    >
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
