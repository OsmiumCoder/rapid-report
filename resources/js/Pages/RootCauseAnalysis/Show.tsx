import { RootCauseAnalysis } from '@/types/rootCauseAnalysis/RootCauseAnalysis';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Incident } from '@/types/incident/Incident';
import { Head, usePage } from '@inertiajs/react';
import classNames from '@/Filters/classNames';
import RootCauseAnalysisAdminActions from '@/Pages/RootCauseAnalysis/Partials/ShowComponents/RootCauseAnalysisAdminActions';
import RootCauseAnalysisInformationPanel from '@/Pages/RootCauseAnalysis/Partials/ShowComponents/RootCauseAnalysisInformationPanel';

export default function Show({ rca, incident }: { rca: RootCauseAnalysis; incident: Incident }) {
    const { user } = usePage().props.auth;
    console.log(rca);
    return (
        <Authenticated>
            <Head title="Root Cause Analysis" />
            <main>
                <div className="mx-auto px-4 py-10 sm:px-6 lg:px-8">
                    <div
                        className={classNames(
                            'mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none ',
                            user.roles.some(({ name }) => name === 'supervisor')
                                ? 'lg:grid-cols-1'
                                : 'lg:grid-cols-3'
                        )}
                    >
                        {user.roles.some(
                            (role) => role.name === 'admin' || role.name === 'super-admin'
                        ) && <RootCauseAnalysisAdminActions rca={rca} />}
                        <RootCauseAnalysisInformationPanel rca={rca} />
                    </div>
                </div>
            </main>
        </Authenticated>
    );
}
