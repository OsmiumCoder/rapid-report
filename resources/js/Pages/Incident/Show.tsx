import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import ActivityLog from '@/Pages/Incident/Partials/ShowComponents/ActivityLog';
import IncidentAdminActions from '@/Pages/Incident/Partials/ShowComponents/IncidentAdminActions';
import IncidentHeader from '@/Pages/Incident/Partials/ShowComponents/IncidentHeader';
import IncidentInformationPanel from '@/Pages/Incident/Partials/ShowComponents/IncidentInformationPanel';
import IncidentSupervisorActions from '@/Pages/Incident/Partials/ShowComponents/IncidentSupervisorActions';
import IncidentUserActions from '@/Pages/Incident/Partials/ShowComponents/IncidentUserActions';
import { PageProps, Role, User } from '@/types';
import { Incident } from '@/types/incident/Incident';
import { Head, router, useForm, usePoll } from '@inertiajs/react';
import { FormEvent, useEffect } from 'react';

interface ShowProps extends PageProps {
    incident: Incident;
    supervisors: User[];
    roles: Role[];
    canRequestReview: boolean;
    canProvideFollowup: boolean;
}

export default function Show({ auth, incident, supervisors, roles, canRequestReview, canProvideFollowup }: PageProps<ShowProps>) {
    const user = auth.user;

    const { data, setData, post, processing, reset } = useForm({
        content: '',
    });

    function addComment(e: FormEvent<HTMLFormElement>) {
        e.preventDefault();
        post(route('incidents.comments.store', { incident: incident.slug }), {
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

    // Refresh file URLs every minute
    usePoll(1000, { only: ['files'] });

    return (
        <AuthenticatedLayout>
            <Head title="Incident" />
            <>
                <main>
                    <IncidentHeader incident={incident}></IncidentHeader>

                    <div className="mx-auto px-4 py-10 sm:px-6 lg:px-8">
                        <div className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            {user.roles.some((role) => role.name === 'admin') && (
                                <IncidentAdminActions incident={incident} supervisors={supervisors} roles={roles}></IncidentAdminActions>
                            )}
                            {user.roles.some((role) => role.name === 'supervisor') && (
                                <IncidentSupervisorActions
                                    incident={incident}
                                    canRequestReview={canRequestReview}
                                    canProvideFollowup={canProvideFollowup}
                                ></IncidentSupervisorActions>
                            )}
                            {user.roles.some((role) => role.name === 'user') && <IncidentUserActions incident={incident}></IncidentUserActions>}

                            <IncidentInformationPanel incident={incident} />

                            {user.roles.some((role) => role.name === 'admin' || role.name === 'supervisor') && (
                                <ActivityLog
                                    data={data}
                                    setData={setData}
                                    processing={processing}
                                    comments={incident.comments}
                                    addComment={addComment}
                                />
                            )}
                        </div>
                    </div>
                </main>
            </>
        </AuthenticatedLayout>
    );
}
