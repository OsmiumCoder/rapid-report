import { IncidentStatus } from '@/Enums/IncidentStatus';
import StatusUpdate from '@/Pages/Incident/Partials/ShowComponents/AdminActionsComponents/StatusUpdate';
import SupervisorUpdate from '@/Pages/Incident/Partials/ShowComponents/AdminActionsComponents/SupervisorUpdate';
import { Role, User } from '@/types';
import { Incident } from '@/types/incident/Incident';

interface AdminActionsProps {
    incident: Incident;
    supervisors: User[];
    roles: Role[];
}
export default function IncidentAdminActions({ incident, supervisors, roles }: AdminActionsProps) {
    return (
        <>
            <div className="rounded-lg bg-white lg:col-start-3 lg:row-end-1">
                <div className="rounded-lg shadow-xs ring-1 ring-gray-900/5">
                    <div className="flex flex-col flex-wrap items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">Administrative Actions</div>
                        {(incident.status === IncidentStatus.OPENED ||
                            incident.status === IncidentStatus.ASSIGNED ||
                            incident.status === IncidentStatus.REOPENED ||
                            incident.status === IncidentStatus.IN_REVIEW) && (
                            <SupervisorUpdate incident={incident} supervisors={supervisors} roles={roles} />
                        )}
                        <StatusUpdate incident={incident} />
                    </div>
                </div>
            </div>
        </>
    );
}
