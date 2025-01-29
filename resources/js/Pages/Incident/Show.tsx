import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminActions from '@/Pages/Incident/Partials/AdminActions';
import ActivityLog from '@/Pages/Incident/Partials/ActivityLog';
import IncidentHeader from '@/Pages/Incident/Partials/IncidentHeader';
import {Head, useForm} from '@inertiajs/react';
import { PageProps, User } from '@/types';
import IncidentInformationPanel from '@/Pages/Incident/Partials/IncidentInformationPanel';
import { Incident } from '@/types/Incident';
import {FormEvent} from "react";

interface ShowProps extends PageProps {
    incident: Incident;
    supervisors: User[];
}

export default function Show({
    auth,
    incident,
    supervisors,
}: PageProps<ShowProps>) {
    const user = auth.user;

    const { data, setData, post, processing, reset } = useForm({
        content: ''
    })

    function addComment(e: FormEvent<HTMLFormElement>) {
        e.preventDefault()
        post(route('incidents.comments.store', {incident: incident.id}), {
            preserveScroll: true,
            onSuccess: () => reset()
        })
    }

    return (
        <AuthenticatedLayout>
            <Head title="Incident" />
            <>
                <main>
                    <IncidentHeader incident={incident}></IncidentHeader>

                    <div className="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            {user.roles.some(
                                (role) =>
                                    role.name === 'admin' ||
                                    role.name === 'super-admin'
                            ) && (
                                <AdminActions
                                    incident={incident}
                                    supervisors={supervisors}
                                ></AdminActions>
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
