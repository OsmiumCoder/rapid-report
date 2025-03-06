import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ReportBuilder from '@/Pages/Report/Partials/ReportBuilder';
import { Head } from '@inertiajs/react';

export default function Index() {
    return (
        <AuthenticatedLayout>
            <Head title="Reports" />
            <ReportBuilder />
        </AuthenticatedLayout>
    );
}
