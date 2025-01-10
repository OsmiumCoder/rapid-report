import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {PageProps} from "@/types";

export default function Create({form}: PageProps<{ form: object }>) {
    return (
        <AuthenticatedLayout>
            <pre>
                {JSON.stringify(form, null, 2)}
            </pre>
        </AuthenticatedLayout>
    );
}
