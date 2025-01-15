import GuestLayout from '@/Layouts/GuestLayout'
import { PageProps } from '@/types'

export default function Create({ form }: PageProps<{ form: object }>) {
    return (
        <GuestLayout>
            <pre>{JSON.stringify(form, null, 2)}</pre>
        </GuestLayout>
    )
}
