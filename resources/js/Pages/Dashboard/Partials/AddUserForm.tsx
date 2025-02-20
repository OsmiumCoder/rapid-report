import Modal from '@/Components/Modal';
import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import InputError from '@/Components/InputError';
import SecondaryButton from '@/Components/SecondaryButton';
import React, { FormEventHandler, useRef, useState } from 'react';
import {router, useForm} from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import {Role} from "@/types";
import {uppercaseWordFormat} from "@/Filters/uppercaseWordFormat";
import SelectInput from "@/Components/SelectInput";

interface AddUserFormProps {
    roles: Role[];
}

export default function AddUserForm({ roles }: AddUserFormProps) {
    const [creatingUser, setCreatingUser] = useState(false);

    const { data, setData, post, processing, errors, clearErrors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        upei_id: '',
        phone: '',
        role: roles.find((role) => role.name === 'supervisor')?.name as string,
    });

    const createUser: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('users.store'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setCreatingUser(false);

        clearErrors();
        reset();
    };

    return (
        <div>
            <PrimaryButton onClick={() => setCreatingUser(true)}>Add User</PrimaryButton>

            <Modal show={creatingUser} onClose={closeModal}>
                <form onSubmit={createUser} className="p-6">
                    <h2 className="text-lg font-medium text-gray-900">
                        Enter the information of the user you wish to create.
                    </h2>

                    <div className="mt-4">
                        <InputLabel htmlFor="name" value="Name" />

                        <TextInput
                            id="name"
                            name="name"
                            value={data.name}
                            className="mt-1 block w-full"
                            autoComplete="name"
                            isFocused={true}
                            onChange={(e) => setData('name', e.target.value)}
                            required
                        />

                        <InputError message={errors.name} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            name="email"
                            value={data.email}
                            className="mt-1 block w-full"
                            autoComplete="username"
                            onChange={(e) => setData('email', e.target.value)}
                            required
                        />

                        <InputError message={errors.email} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="password" value="Password" />

                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            value={data.password}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password', e.target.value)}
                            required
                        />

                        <InputError message={errors.password} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="password_confirmation" value="Confirm Password" />

                        <TextInput
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            value={data.password_confirmation}
                            className="mt-1 block w-full"
                            autoComplete="new-password"
                            onChange={(e) => setData('password_confirmation', e.target.value)}
                            required
                        />

                        <InputError message={errors.password_confirmation} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="upei_id" value="UPEI ID" />

                        <TextInput
                            id="upei_id"
                            name="upei_id"
                            value={data.upei_id}
                            className="mt-1 block w-full"
                            onChange={(e) => setData('upei_id', e.target.value)}
                            required
                        />

                        <InputError message={errors.upei_id} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="phone" value="Phone Number" />

                        <TextInput
                            id="phone"
                            name="phone"
                            type="tel"
                            value={data.phone}
                            className="mt-1 block w-full"
                            autoComplete="phone"
                            onChange={(e) => setData('phone', e.target.value)}
                        />

                        <InputError message={errors.phone} className="mt-2" />
                    </div>

                    <div className="mt-4">
                        <InputLabel htmlFor="role" value="Role" />

                        <SelectInput
                            value={data.role}
                            onChange={(e) => setData('role', e.target.value)}
                        >
                            {roles.map(({ name }, index) => (
                                <option
                                    className="hover:bg-upei-green-500"
                                    key={index}
                                    value={name}
                                >
                                    {uppercaseWordFormat(name, '-')}
                                </option>
                            ))}
                        </SelectInput>

                        <InputError message={errors.role} className="mt-2" />
                    </div>

                    <div className="mt-6 flex justify-between">
                        <DangerButton onClick={closeModal}>Cancel</DangerButton>

                        <PrimaryButton className="ms-3" disabled={processing}>
                            Add User
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>
        </div>
    );
}
