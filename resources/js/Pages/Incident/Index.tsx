import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import {PageProps} from "@/types";

export default function Index({incidents}: PageProps<{ incidents: object }>) {
    return (
        <AuthenticatedLayout>
            <Head title="Incidents" />

            <pre>
                {JSON.stringify(incidents, null, 2)}
            </pre>
        </AuthenticatedLayout>
    );
}
