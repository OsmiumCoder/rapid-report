import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';

export default function Create() {
    const { data, setData, post } = useForm({
        individuals_involved: [
            {
                name: '',
                email: '',
                phone: '',
            },
        ],
        primary_effect: '',
        effective_solutions: [],
        corrective_actions: [],
        peoples_position: [],
        attention_to_work: [],
        communication: [],
        ppe_in_good_condition: false,
        ppe_in_use: false,
        ppe_correct_type: false,
        correct_tool_used: false,
        policies_followed: false,
        worked_safely: false,
        used_tool_properly: false,
        tool_in_good_condition: false,
        working_conditions: [],
        root_causes: [],
    });
    const handleSubmit = () => {};
    return (
        <Authenticated>
            <Head title="New Root Cause Analysis" />
            <form
                onSubmit={handleSubmit}
                className="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-md"
            >
                <InputLabel className="my-2 font-bold text-lg">Individuals Involved</InputLabel>
                <div className="flex flex-col w-full">
                    {data['individuals_involved'].map(({ name, email, phone }) => (
                        <div className="flex flex-col gap-y-2 border-b border-gray-200 py-2">
                            <InputLabel>Name</InputLabel>
                            <TextInput value={name} />
                            <InputLabel>Email</InputLabel>
                            <TextInput value={email} />
                            <InputLabel>Phone</InputLabel>
                            <TextInput value={phone} />
                        </div>
                    ))}
                    <div>
                        <PrimaryButton
                            className="self-end my-2"
                            onClick={() =>
                                setData('individuals_involved', [
                                    ...data['individuals_involved'],
                                    { name: '', email: '', phone: '' },
                                ])
                            }
                        >
                            Add
                        </PrimaryButton>
                        <DangerButton>Delete</DangerButton>
                    </div>
                </div>
            </form>
        </Authenticated>
    );
}
