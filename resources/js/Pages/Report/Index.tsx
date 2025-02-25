import dateFormat from '@/Filters/dateFormat';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ReportBuilder from '@/Pages/Report/Partials/ReportBuilder';
import type ReportData from '@/types/report/ReportData';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';

export default function Index() {
    const { data: formData, setData } = useForm({
        start: dateFormat(dayjs(Date.now()).subtract(1).toDate()),
        end: dateFormat(Date.now()),
        happened_at: false,
        work_related: false,
        personal_individual_information: false,
        workers_comp_submitted: false,
        location: false,
        room_number: false,
        incident_type: false,
        descriptor: false,
        description: false,
        injury_description: false,
        first_aid_description: false,
        closed_at: false,
        created_at: false,
        updated_at: false,
    });

    const setFormData = (key: keyof ReportData, value: any) => setData(key, value);
    return (
        <AuthenticatedLayout>
            <Head title="Reports" />
            <ReportBuilder formData={formData} setFormData={setFormData} />
        </AuthenticatedLayout>
    );
}
