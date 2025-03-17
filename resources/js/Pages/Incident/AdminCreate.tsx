import DangerButton from '@/Components/DangerButton';
import DateInput from '@/Components/DateInput';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import PrimaryButtonDivider from '@/Components/PrimaryButtonDivider';
import SelectInput from '@/Components/SelectInput';
import TextArea from '@/Components/TextArea';
import TextInput from '@/Components/TextInput';
import ToggleSwitch from '@/Components/ToggleSwitch';
import classNames from '@/Formatters/classNames';
import dateFormat from '@/Formatters/dateFormat';
import phoneNumberFormat from '@/Formatters/phoneNumberFormat';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { descriptors, locations, roles } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import IncidentData from '@/types/incident/IncidentData';
import { PlusIcon } from '@heroicons/react/20/solid';
import { Head, useForm } from '@inertiajs/react';
import { FormEvent, useEffect } from 'react';

export default function AdminCreate({ incidentData }: { incidentData: IncidentData }) {
    const { data, setData, processing, errors, post } = useForm<Partial<IncidentData>>(incidentData);

    const handleSubmit = (e: FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        post(route('incidents.store', { admin_submission: true }));
    };

    useEffect(() => {
        setData('role', roles[0].value);
        setData('happened_at', dateFormat(new Date()));
        setData('incident_type', descriptors[0].value);
        setData('descriptor', descriptors[0].options[0]);
        setData('anonymous', false);
        setData('on_behalf', false);
        setData('on_behalf_anonymous', false);
        setData('work_related', false);
        setData('has_injury', false);
        setData('workers_comp_submitted', false);
        setData('supervisor_name', '');
    }, [setData]);

    return (
        <Authenticated>
            <Head title={'Record Incident'} />
            <form onSubmit={handleSubmit} className="mx-auto max-w-4xl space-y-4 rounded-md bg-white p-6 shadow-md">
                <div className="text-center text-xl font-semibold text-gray-900">Record Incident</div>

                <div className="space-y-2">
                    <InputLabel>Anonymous</InputLabel>
                    <ToggleSwitch onChange={(selected) => setData('anonymous', selected)} />
                </div>
                {!data['anonymous'] && (
                    <div className="space-y-2">
                        <InputLabel>Reporters Email</InputLabel>
                        <TextInput value={data.reporters_email} onChange={(e) => setData('reporters_email', e.target.value)} />
                    </div>
                )}
                <div className="space-y-2">
                    <InputLabel>On Behalf</InputLabel>
                    <ToggleSwitch onChange={(selected) => setData('on_behalf', selected)} />
                </div>
                {data.on_behalf && (
                    <div className="space-y-2">
                        <InputLabel>On Behalf Anonymous</InputLabel>
                        <ToggleSwitch onChange={(selected) => setData('on_behalf_anonymous', selected)} />
                    </div>
                )}

                {((!data.anonymous && !data.on_behalf) ||
                    (!data.anonymous && data.on_behalf && !data.on_behalf_anonymous) ||
                    (data.anonymous && data.on_behalf && !data.on_behalf_anonymous)) && (
                    <>
                        <div className="space-y-2">
                            <InputLabel>First Name</InputLabel>
                            <TextInput value={data.first_name} onChange={(e) => setData('first_name', e.target.value)} />
                        </div>
                        <div className="space-y-2">
                            <InputLabel>Last Name</InputLabel>
                            <TextInput value={data.last_name} onChange={(e) => setData('last_name', e.target.value)} />
                        </div>
                        <div className="space-y-2">
                            <InputLabel>Phone Number</InputLabel>
                            <TextInput value={data.phone} onChange={(e) => setData('phone', phoneNumberFormat(e.target.value))} />
                        </div>
                        <div className="space-y-2">
                            <InputLabel>Email</InputLabel>
                            <TextInput value={data.email} onChange={(e) => setData('email', e.target.value)} />
                        </div>
                        <div className="space-y-2">
                            <InputLabel>Incident Role</InputLabel>
                            <SelectInput
                                value={roles.find(({ value }) => value === data?.role)?.name ?? roles[0].name}
                                onChange={(e) => {
                                    const role = roles.find(({ name }) => name === e.target.value);
                                    setData('role', role?.value);
                                    if (role?.name === 'Contractor' || role?.name === 'Visitor') {
                                        setData('upei_id', '');
                                    }
                                }}
                            >
                                {roles.map(({ name }, i) => (
                                    <option key={i}>{name}</option>
                                ))}
                            </SelectInput>
                        </div>
                        {(data.role === 1 || data.role === 2) && (
                            <div className="space-y-2">
                                <InputLabel>UPEI ID</InputLabel>
                                <TextInput onChange={(e) => setData('upei_id', e.target.value)} />
                            </div>
                        )}
                    </>
                )}

                <div className="space-y-2">
                    <InputLabel>Happened On</InputLabel>
                    <DateInput value={data.happened_at} onChange={(e) => setData('happened_at', e.target.value)} />
                </div>
                <div className="space-y-2">
                    <InputLabel>Work Related</InputLabel>
                    <ToggleSwitch onChange={(selected) => setData('work_related', selected)} />
                </div>
                <div className="space-y-2">
                    <InputLabel>Location</InputLabel>
                    <SelectInput value={data['location'] ?? ''} onChange={(e) => setData('location', e.target.value)}>
                        {locations.map((option, index) => (
                            <option key={index} value={option}>
                                {option}
                            </option>
                        ))}
                    </SelectInput>
                </div>
                <div className="space-y-2">
                    <InputLabel>Room Number</InputLabel>
                    <TextInput value={data.room_number} onChange={(e) => setData('room_number', e.target.value)} />
                </div>
                <div className="space-y-2">
                    <InputLabel>Incident Type</InputLabel>
                    <SelectInput
                        value={descriptors.find(({ value }) => value === data?.incident_type)?.name ?? descriptors[0].name}
                        onChange={(e) => {
                            setData('incident_type', descriptors.find(({ name }) => name === e.target.value)?.value);
                        }}
                    >
                        {descriptors.map(({ name }, index) => (
                            <option key={index}>{name}</option>
                        ))}
                    </SelectInput>
                </div>
                <div>
                    <InputLabel>Descriptor</InputLabel>
                    <SelectInput value={data.descriptor} onChange={(e) => setData('descriptor', e.target.value)} className="w-full">
                        {descriptors.map(
                            ({ options, value }) =>
                                value === data.incident_type && options.map((option, index) => <option key={index}>{option}</option>),
                        )}
                    </SelectInput>
                </div>
                <div className="space-y-2">
                    <InputLabel>Has Injury</InputLabel>
                    <ToggleSwitch onChange={(selected) => setData('has_injury', selected)} />
                </div>
                {data.has_injury && (
                    <>
                        <div className="space-y-2">
                            <InputLabel>Injury Description</InputLabel>
                            <TextArea value={data.injury_description} onChange={(e) => setData('injury_description', e.target.value)} />
                        </div>
                        {data.work_related && (
                            <div className="space-y-2">
                                <InputLabel>Workers Compensation Claim Submitted</InputLabel>
                                <ToggleSwitch onChange={(selected) => setData('workers_comp_submitted', selected)} />
                            </div>
                        )}
                    </>
                )}

                <div className="space-y-2">
                    <InputLabel>Has First Aid</InputLabel>
                    <ToggleSwitch onChange={(selected) => setData('first_aid_applied', selected)} />
                </div>
                {data.first_aid_applied && (
                    <div className="space-y-2">
                        <InputLabel>Injury Description</InputLabel>
                        <TextArea value={data.first_aid_description} onChange={(e) => setData('first_aid_description', e.target.value)} />
                    </div>
                )}
                <div className="space-y-2">
                    <InputLabel>General Description</InputLabel>
                    <TextArea value={data.description} onChange={(e) => setData('description', e.target.value)} />
                </div>

                <div className="flex w-full flex-col">
                    {data.witnesses?.map(({ name, email, phone }, i) => (
                        <div
                            key={i}
                            className={classNames(
                                'flex flex-col gap-y-2 py-4',
                                data.witnesses && i !== data.witnesses.length - 1 ? 'border-b border-gray-200' : '',
                            )}
                        >
                            <div className="flex justify-between">
                                <p>{`Witness #${i + 1}`}</p>
                                <DangerButton
                                    type="button"
                                    onClick={() => setData('witnesses', [...(data.witnesses?.filter((_, index) => i !== index) ?? [])])}
                                >
                                    Delete
                                </DangerButton>
                            </div>
                            <InputLabel>Name</InputLabel>
                            <TextInput
                                value={name}
                                onChange={(e) => {
                                    if (!data.witnesses) return;
                                    data.witnesses[i].name = e.target.value;
                                    setData('witnesses', data.witnesses);
                                }}
                            />
                            <InputError message={errors[`witnesses.${i}.name` as keyof IncidentData]} className="mb-1" />
                            <InputLabel>Email</InputLabel>
                            <TextInput
                                onChange={(e) => {
                                    if (!data.witnesses) return;
                                    data.witnesses[i].email = e.target.value;
                                    setData('witnesses', data.witnesses);
                                }}
                                value={email}
                            />
                            <InputError message={errors[`witnesses.${i}.email` as keyof IncidentData]} className="mb-1" />
                            <InputLabel>Phone</InputLabel>
                            <TextInput
                                onChange={(e) => {
                                    if (!data.witnesses) return;
                                    data.witnesses[i].phone = phoneNumberFormat(e.target.value);
                                    setData('witnesses', data.witnesses);
                                }}
                                value={phone}
                            />
                            <InputError message={errors[`witnesses.${i}.phone` as keyof IncidentData]} className="mb-1" />
                        </div>
                    ))}
                    <PrimaryButtonDivider
                        type="button"
                        className="self-end"
                        onClick={() => setData('witnesses', [...(data.witnesses ?? []), { name: '', email: '', phone: '' }])}
                    >
                        <PlusIcon className="size-5" />
                        Add Witness
                    </PrimaryButtonDivider>
                </div>

                <div className="space-y-2">
                    <InputLabel>Supervisor Name</InputLabel>
                    <TextInput value={data.supervisor_name} onChange={(e) => setData('supervisor_name', e.target.value)} />
                </div>
                <div className="flex justify-center">
                    <PrimaryButton disabled={processing} className="mt-6 w-20">
                        Submit
                    </PrimaryButton>
                </div>
            </form>
        </Authenticated>
    );
}
