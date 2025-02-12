import GuestLayout from '@/Layouts/GuestLayout';
import { PageProps } from '@/types';
import React from 'react';
import { CheckCircleIcon } from '@heroicons/react/24/outline';
import {Head, Link} from '@inertiajs/react';

export default function Created({
    can_view,
    incident_id,
}: PageProps<{ can_view: boolean; incident_id: string }>) {
    return (
        <GuestLayout>
            <Head title="Submitted Incident" />
            <div className="flex flex-col items-center w-full">
                <div>
                    <CheckCircleIcon className="size-16 text-upei-green-500" />
                </div>
                <div className="text-xl my-2">Thank you for submitting an Incident report.</div>
                <div className="my-2">
                    Your incident will be reviewed and investigated in due process.
                </div>
                {can_view && (
                    <div className="my-2">
                        <Link
                            href={route('incidents.show', {
                                incident: incident_id,
                            })}
                            as="button"
                            className="rounded-md bg-upei-green-500 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-upei-green-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600"
                        >
                            View Incident
                        </Link>
                    </div>
                )}
            </div>
        </GuestLayout>
    );
}
