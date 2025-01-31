import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {Incident} from "@/types/Incident";

export default function Index({ incidents }: {incidents: Incident[]}) {
    return (
        <AuthenticatedLayout>
            <pre>
                {JSON.stringify(incidents, null, 2)}
            </pre>
        </AuthenticatedLayout>
    );
}
