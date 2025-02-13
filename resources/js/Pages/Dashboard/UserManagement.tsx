import Authenticated from '@/Layouts/AuthenticatedLayout';
import {Head, Link, router, WhenVisible} from '@inertiajs/react';
import {PaginatedResponse} from "@/types/PaginatedResponse";
import {User} from "@/types";
import Pagination from "@/Components/Pagination";
import {XMarkIcon} from "@heroicons/react/20/solid";
import PrimaryButton from "@/Components/PrimaryButton";
import {PencilIcon} from "@heroicons/react/24/outline";
import {returnInvestigation} from "@/Helpers/Incident/statusUpdates";
import {useConfirmationModalProps} from "@/Components/ConfirmationModal";
import SecondaryButton from "@/Components/SecondaryButton";
import DangerButton from "@/Components/DangerButton";

interface UserManagementProps {
    users: PaginatedResponse<User>
}

export default function UserManagement({ users }: UserManagementProps) {
    const [modalProps, setModalProps] = useConfirmationModalProps();

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
                    </div>
                    <div className="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <button
                            type="button"
                            className="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            Add user
                        </button>
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
                                                    {user.roles[0].name}
                                                </td>
                                                <td className="flex justify-end whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <DangerButton
                                                        onClick={() =>
                                                            setModalProps({
                                                                title: 'Delete User',
                                                                text: `Are you sure you want to delete ${user.name} from the system?`,
                                                                action: () => "",
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
