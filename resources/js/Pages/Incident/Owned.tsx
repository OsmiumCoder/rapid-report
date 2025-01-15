import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout'
import { Head } from '@inertiajs/react'

export default function Owned({ incidents }: any) {
    return (
        <AuthenticatedLayout>
            <Head title="Incidents" />

            <pre>{JSON.stringify(incidents, null, 2)}</pre>
        </AuthenticatedLayout>
    )
}
