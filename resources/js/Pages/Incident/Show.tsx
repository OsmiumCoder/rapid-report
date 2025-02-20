import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import IncidentAdminActions from '@/Pages/Incident/Partials/ShowComponents/IncidentAdminActions';
import ActivityLog from '@/Pages/Incident/Partials/ShowComponents/ActivityLog';
import IncidentHeader from '@/Pages/Incident/Partials/ShowComponents/IncidentHeader';
import { Head, router, useForm } from '@inertiajs/react';
import { PageProps, User } from '@/types';
import IncidentInformationPanel from '@/Pages/Incident/Partials/ShowComponents/IncidentInformationPanel';
import { Incident } from '@/types/incident/Incident';
import { FormEvent, useEffect } from 'react';
import IncidentSupervisorActions from '@/Pages/Incident/Partials/ShowComponents/IncidentSupervisorActions';
import { IncidentStatus } from '@/Enums/IncidentStatus';

interface ShowProps extends PageProps {
    incident: Incident;
    supervisors: User[];
    canRequestReview: boolean;
    canProvideFollowup: boolean;
}

export default function Show({
    auth,
    incident,
    supervisors,
    canRequestReview,
    canProvideFollowup,
}: PageProps<ShowProps>) {
    const user = auth.user;

    const { data, setData, post, processing, reset } = useForm({
        content: '',
    });

    function addComment(e: FormEvent<HTMLFormElement>) {
        e.preventDefault();
        post(route('incidents.comments.store', { incident: incident.id }), {
            preserveScroll: true,
            onSuccess: () => reset(),
        });
    }
    useEffect(() => {
        // Refresh incidents prop (if exists) when browser back navigation occurs.
        const reloadIncidents = () => router.reload({ only: ['incidents'] });

        window.addEventListener('popstate', reloadIncidents);

        return () => {
            window.removeEventListener('popstate', reloadIncidents);
        };
    }, []);

    return (
        <AuthenticatedLayout>
            <Head title="Incident" />
            <>
                <main>
                    <IncidentHeader incident={incident}></IncidentHeader>

                    <div className="mx-auto px-4 py-10 sm:px-6 lg:px-8">
                        <div className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            {user.roles.some(
                                (role) => role.name === 'admin' || role.name === 'super-admin'
                            ) && (
                                <IncidentAdminActions
                                    incident={incident}
                                    supervisors={supervisors}
                                ></IncidentAdminActions>
                            )}
                            {user.roles.some((role) => role.name === 'supervisor') && (
                                <IncidentSupervisorActions
                                    incident={incident}
                                    canRequestReview={canRequestReview}
                                    canProvideFollowup={canProvideFollowup}
                                ></IncidentSupervisorActions>
                            )}

                            <IncidentInformationPanel incident={incident} />

                            <ActivityLog
                                data={data}
                                setData={setData}
                                processing={processing}
                                comments={incident.comments}
                                addComment={addComment}
                            />
                        </div>
                    </div>
                </main>
            </>
        </AuthenticatedLayout>
    );
}
