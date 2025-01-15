import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {PageProps} from "@/types";

export default function Index({incident}: PageProps<{ incident: any }>) {
    return (
        <AuthenticatedLayout>
            <Head title="Incident" />

            <pre>
                {JSON.stringify(incident, null, 2)}
            </pre>
        </AuthenticatedLayout>
    );
}
