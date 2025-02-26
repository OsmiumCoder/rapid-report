import dateFormat from '@/Filters/dateFormat';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ReportBuilder from '@/Pages/Report/Partials/ReportBuilder';
import type ReportData from '@/types/report/ReportData';
import { Head, useForm } from '@inertiajs/react';
import dayjs from 'dayjs';
import {useCallback} from "react";

export default function Index() {
    const { data: formData, setData } = useForm({
        start: dateFormat(dayjs(Date.now()).subtract(1).toDate()),
        end: dateFormat(Date.now()),
        happened_at: false as boolean,
        work_related: false as boolean,
        personal_individual_information: false as boolean,
        workers_comp_submitted: false as boolean,
        location: false as boolean,
        room_number: false as boolean,
        incident_type: false as boolean,
        descriptor: false as boolean,
        description: false as boolean,
        injury_description: false as boolean,
        first_aid_description: false as boolean,
        closed_at: false as boolean,
        created_at: false as boolean,
        updated_at: false as boolean,
    });

    const setFormData = useCallback((key: keyof ReportData, value: ReportData[keyof ReportData]) => setData(key, value), [setData]);

    return (
        <AuthenticatedLayout>
            <Head title="Reports" />
            <ReportBuilder formData={formData} setFormData={setFormData} />
        </AuthenticatedLayout>
    );
}
