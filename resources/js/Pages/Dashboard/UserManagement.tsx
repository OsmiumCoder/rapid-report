import { useConfirmationModal } from '@/Components/ConfirmationModal/ConfirmationModalProvider';
import DangerButton from '@/Components/DangerButton';
import Pagination from '@/Components/Pagination';
import PrimaryButton from '@/Components/PrimaryButton';
import SelectInput from '@/Components/SelectInput';
import TextInput from '@/Components/TextInput';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import AddUserModal from '@/Pages/Dashboard/Partials/AddUserModal';
import { Role, User } from '@/types';
import { PaginatedResponse } from '@/types/PaginatedResponse';
import { Head, router } from '@inertiajs/react';
import { useState } from 'react';
import _ from 'underscore';

interface UserManagementProps {
    users: PaginatedResponse<User>;
    roles: Role[];
}

export default function UserManagement({ users, roles }: UserManagementProps) {
    const { setModalProps } = useConfirmationModal();
    const [isAddUserFormOpen, setIsAddUserFormOpen] = useState(false);
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
                            A list of all the users in your account including their name, title, email and role.
                        </p>
                        <div className="mt-2 w-1/2 text-sm text-gray-700">
                            <TextInput placeholder="Search" onChange={(e) => searchUsers(e.target.value)} />
                        </div>
                    </div>
                    <div className="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <PrimaryButton onClick={() => setIsAddUserFormOpen(true)}>Add User</PrimaryButton>
                    </div>
                </div>
                <div className="mt-8 flow-root">
                    <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div className="overflow-hidden shadow-sm ring-1 ring-black/5 sm:rounded-lg">
                                <table className="min-w-full divide-y divide-gray-300">
                                    <thead className="bg-gray-50">
                                        <tr>
                                            <th scope="col" className="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                Name
                                            </th>
                                            <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Email
                                            </th>
                                            <th scope="col" className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Role
                                            </th>
                                            <th scope="col" className="relative py-3.5 pr-4 pl-3 sm:pr-6">
                                                <span className="sr-only">Edit</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-200 bg-white">
                                        {users.data.map((user, index) => (
                                            <tr key={index}>
                                                <td className="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6">
                                                    {user.name}
                                                </td>
                                                <td className="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{user.email}</td>
                                                <td className="px-3 py-4 text-sm whitespace-nowrap text-gray-500">
                                                    <SelectInput
                                                        value={user.roles[0].name}
                                                        onChange={(e) => {
                                                            router.patch(
                                                                route('users.update-role', {
                                                                    user: user.id,
                                                                }),
                                                                { role: e.target.value },
                                                            );
                                                        }}
                                                        className="w-full"
                                                    >
                                                        {roles.map(({ name }, index) => (
                                                            <option className="hover:bg-upei-green-500" key={index} value={name}>
                                                                {uppercaseWordFormat(name, '-')}
                                                            </option>
                                                        ))}
                                                    </SelectInput>
                                                </td>
                                                <td className="flex justify-end py-4 pr-4 pl-3 text-sm whitespace-nowrap text-gray-500 sm:pl-6">
                                                    <DangerButton
                                                        onClick={() =>
                                                            setModalProps({
                                                                title: 'Delete User',
                                                                text: `Are you sure you want to delete ${user.name} from the system?`,
                                                                action: () => {
                                                                    router.delete(
                                                                        route('users.destroy', {
                                                                            user: user.id,
                                                                        }),
                                                                    );
                                                                },
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
                                <Pagination<User> pagination={users} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <AddUserModal roles={roles} isOpen={isAddUserFormOpen} onClose={() => setIsAddUserFormOpen(false)} />
        </Authenticated>
    );
}
