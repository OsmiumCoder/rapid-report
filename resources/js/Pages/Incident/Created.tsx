import GuestLayout from '@/Layouts/GuestLayout';
import { PageProps } from '@/types';
import { CheckCircleIcon } from '@heroicons/react/24/outline';
import { Head, Link } from '@inertiajs/react';

export default function Created({ can_view, incident_id }: PageProps<{ can_view: boolean; incident_id: string }>) {
    return (
        <GuestLayout>
            <Head title="Submitted Incident" />
            <div className="flex w-full flex-col items-center">
                <div>
                    <CheckCircleIcon className="text-upei-green-500 size-16" />
                </div>
                <div className="my-2 text-xl">Thank you for submitting an Incident report.</div>
                <div className="my-2">Your incident will be reviewed and investigated in due process.</div>
                <div className="my-2 flex w-3/4 justify-around">
                    <div>
                        <Link
                            href={route('login')}
                            as="button"
                            className="bg-upei-red-500 hover:bg-upei-red-600 focus-visible:outline-upei-red-600 cursor-pointer rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                        >
                            Return Home
                        </Link>
                    </div>

                    {can_view && (
                        <div>
                            <Link
                                href={route('incidents.show', {
                                    incident: incident_id,
                                })}
                                as="button"
                                className="bg-upei-green-500 hover:bg-upei-green-600 focus-visible:outline-upei-green-600 cursor-pointer rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                View Incident
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </GuestLayout>
    );
}
