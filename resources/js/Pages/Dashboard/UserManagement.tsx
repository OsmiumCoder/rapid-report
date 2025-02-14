import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head, router } from '@inertiajs/react';
import { PaginatedResponse } from '@/types/PaginatedResponse';
import { Role, User } from '@/types';
import Pagination from '@/Components/Pagination';
import DangerButton from '@/Components/DangerButton';
import SelectInput from '@/Components/SelectInput';
import React from 'react';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import _ from 'underscore';
import {useConfirmationModal} from "@/Components/confirmationModal/ConfirmationModalProvider";

interface UserManagementProps {
    users: PaginatedResponse<User>;
    roles: Role[];
}

export default function UserManagement({ users, roles }: UserManagementProps) {
    const { setModalProps } = useConfirmationModal();

    const searchUsers = _.debounce((search: string) => {
        router.reload({
            data: { search: search, page: 1 },
            only: ['users'],
        });
    }, 300);

    return (
        <Authenticated>
            <Head title="User Management" />

            <div className="px-4 sm:px-6 lg:px-8">
                <div className="sm:flex sm:items-center">
                    <div className="sm:flex-auto">
                        <h1 className="text-base font-semibold text-gray-900">Users</h1>
                        <p className="mt-2 text-sm text-gray-700">
                            A list of all the users in your account including their name, title,
                            email and role.
                        </p>
                        <div className="w-1/2 mt-2 text-sm text-gray-700">
                            <TextInput
                                placeholder="Search"
                                onChange={(e) => searchUsers(e.target.value)}
                            />
                        </div>
                    </div>
                    <div className="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <PrimaryButton
                            onClick={() =>
                                setModalProps({
                                    title: 'Add User',
                                    text: `Fill out the details:`,
                                    show: true,
                                })
                            }
                        >
                            Add User
                        </PrimaryButton>
                    </div>
                </div>
                <div className="mt-8 flow-root">
                    <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div className="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                                <table className="min-w-full divide-y divide-gray-300">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th
                                                scope="col"
                                                className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                Name
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Email
                                            </th>
                                            <th
                                                scope="col"
                                                className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                            >
                                                Role
                                            </th>
                                            <th
                                                scope="col"
                                                className="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                            >
                                                <span className="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-200 bg-white">
                                        {users.data.map((user, index) => (
                                            <tr key={index}>
                                                <td className="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {user.name}
                                                </td>
                                                <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {user.email}
                                                </td>
                                                <td className="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <SelectInput
                                                        value={user.roles[0].name}
                                                        onChange={(e) => {
                                                            console.log(e.target.value);
                                                        }}
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
                                                </td>
                                                <td className="flex justify-end whitespace-nowrap py-4 pl-3 pr-4 sm:pl-6 text-sm text-gray-500">
                                                    <DangerButton
                                                        onClick={() =>
                                                            setModalProps({
                                                                title: 'Delete User',
                                                                text: `Are you sure you want to delete ${user.name} from the system?`,
                                                                show: true,
                                                            })
                                                        }
                                                    >
                                                        Delete User
                                                    </DangerButton>
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                                <Pagination pagination={users} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
