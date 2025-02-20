import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import IncidentAdminActions from '@/Pages/Incident/Partials/ShowComponents/IncidentAdminActions';
import ActivityLog from '@/Pages/Incident/Partials/ShowComponents/ActivityLog';
import IncidentHeader from '@/Pages/Incident/Partials/ShowComponents/IncidentHeader';
import { Head, useForm } from '@inertiajs/react';
import { PageProps, User } from '@/types';
import IncidentInformationPanel from '@/Pages/Incident/Partials/ShowComponents/IncidentInformationPanel';
import { Incident } from '@/types/incident/Incident';
import { FormEvent } from 'react';
import IncidentSupervisorActions from '@/Pages/Incident/Partials/ShowComponents/IncidentSupervisorActions';
import { IncidentStatus } from '@/Enums/IncidentStatus';

interface ShowProps extends PageProps {
    incident: Incident;
    supervisors: User[];
}

export default function Show({ auth, incident, supervisors }: PageProps<ShowProps>) {
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
                            {user.roles.some((role) => role.name === 'supervisor') &&
                                incident.status === IncidentStatus.ASSIGNED && (
                                    <IncidentSupervisorActions
                                        incident={incident}
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
