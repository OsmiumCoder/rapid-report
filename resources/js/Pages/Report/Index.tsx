import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {Incident} from "@/types/Incident";


export default function Index({ incidents }: {incidents: Incident[]}) {
    let catagories = Incident.getOwnPropertyNames();
    return (
        <AuthenticatedLayout>


        </AuthenticatedLayout>
    );
}
