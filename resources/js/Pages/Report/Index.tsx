import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import ReportData from "@/types/report/ReportData";
import {useState} from "react";
import {Incident} from "@/types/incident/Incident";
import ReportBuildingBlock from "@/Pages/Report/Partials/ReportBuildingBlock";
import ReportBuilder from "@/Pages/Report/Partials/ReportBuilder";


export default function Index({ incidents }: {incidents: Incident[]}) {
    const [selectedCat, setSelectedCat] = useState<ReportData>({
        closed_at: false,
        created_at: false,
        deleted_at: false,
        description: false,
        descriptor: false,
        first_aid_description: false,
        happened_at: false,
        incident_type: false,
        injury_description: false,
        location: false,
        room_number: false,
        updated_at: false,
        work_related: false,
        workers_comp_submitted: false
    });
    return (
        <AuthenticatedLayout>
        <ReportBuilder formData={selectedCat} setFormData={setSelectedCat}/>

        </AuthenticatedLayout>
    );
}
