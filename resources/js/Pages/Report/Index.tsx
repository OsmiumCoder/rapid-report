import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import type ReportData from "@/types/report/ReportData";
import ReportBuilder from "@/Pages/Report/Partials/ReportBuilder";
import {useForm} from "@inertiajs/react";


export default function Index({ form }: {form: ReportData}) {

    const {
        data: formData,
        setData,
        post,
        processing,
    } = useForm<Partial<ReportData>>(form);
    const setFormData = (key: keyof ReportData, value: any) =>
        setData(key, value);
    return (
        <AuthenticatedLayout>
        <ReportBuilder formData={formData} post={post} setFormData={setFormData}/>

        </AuthenticatedLayout>
    );
}
