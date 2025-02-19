import { Incident } from '@/types/incident/Incident';
import { User } from '@/types';
import SupervisorUpdate from '@/Pages/Incident/Partials/ShowComponents/AdminActionComponents/SupervisorUpdate';
import StatusUpdate from '@/Pages/Incident/Partials/ShowComponents/AdminActionComponents/StatusUpdate';
import { IncidentStatus } from '@/Enums/IncidentStatus';

interface AdminActionsProps {
    incident: Incident;
    supervisors: User[];
}
export default function IncidentAdminActions({ incident, supervisors }: AdminActionsProps) {
    return (
        <>
            <div className="lg:col-start-3 lg:row-end-1 bg-white rounded-lg">
                <div className="rounded-lg  shadow-sm ring-1 ring-gray-900/5">
                    <div className="flex flex-wrap flex-col items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">
                            Administrative Actions
                        </div>
                        {(incident.status === IncidentStatus.OPENED ||
                            incident.status === IncidentStatus.ASSIGNED ||
                            incident.status === IncidentStatus.REOPENED ||
                            incident.status === IncidentStatus.IN_REVIEW) && (
                            <SupervisorUpdate incident={incident} supervisors={supervisors} />
                        )}
                        <StatusUpdate incident={incident} />
                    </div>
                </div>
            </div>
        </>
    );
}
