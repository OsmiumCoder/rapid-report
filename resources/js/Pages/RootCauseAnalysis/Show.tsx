import Authenticated from '@/Layouts/AuthenticatedLayout';
import ActivityLog from '@/Pages/Incident/Partials/ShowComponents/ActivityLog';
import RootCauseAnalysisAdminActions from '@/Pages/RootCauseAnalysis/Partials/ShowComponents/RootCauseAnalysisAdminActions';
import RootCauseAnalysisInformationPanel from '@/Pages/RootCauseAnalysis/Partials/ShowComponents/RootCauseAnalysisInformationPanel';
import { Incident } from '@/types/incident/Incident';
import { RootCauseAnalysis } from '@/types/rootCauseAnalysis/RootCauseAnalysis';
import { Head, usePage } from '@inertiajs/react';

export default function Show({ rca }: { rca: RootCauseAnalysis; incident: Incident }) {
    const { user } = usePage().props.auth;

    return (
        <Authenticated>
            <Head title="Root Cause Analysis" />
            <main>
                <div className="mx-auto px-4 py-10 sm:px-6 lg:px-8">
                    <div className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                        {user.roles.some((role) => role.name === 'admin') && <RootCauseAnalysisAdminActions rca={rca} />}
                        <RootCauseAnalysisInformationPanel rca={rca} />
                        <ActivityLog incident={rca.incident} />
                    </div>
                </div>
            </main>
        </Authenticated>
    );
}
