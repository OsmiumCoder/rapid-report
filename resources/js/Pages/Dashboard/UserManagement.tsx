import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {PaginatedResponse} from "@/types/PaginatedResponse";
import {User} from "@/types";

interface UserManagementProps {
    users: PaginatedResponse<User>
}

export default function UserManagement({ users }: UserManagementProps) {
    return (
        <Authenticated>
            <Head title="User Management" />
            <pre>
                {JSON.stringify(users, null, 2)}
            </pre>
        </Authenticated>
    );
}
