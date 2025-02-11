import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function UserManagement() {
    return (
        <Authenticated>
            <Head title="User Management" />
            <div>User Management</div>
        </Authenticated>
    );
}
