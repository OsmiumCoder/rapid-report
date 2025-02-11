import { Incident } from '@/types/incident/Incident';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import OverviewTable from '@/Pages/Dashboard/Partials/OverviewTable';
import { Head, Link } from '@inertiajs/react';
import { IncidentStatus } from '@/Enums/IncidentStatus';

interface SupervisorDashboardProps {
    unresolvedIncidents: Incident[];
    incidentCount: number;
    closedCount: number;
    unresolvedCount: number;
}

export default function SupervisorOverview({
    unresolvedIncidents,
    incidentCount,
    closedCount,
    unresolvedCount,
}: SupervisorDashboardProps) {
    return (
        <Authenticated>
            <Head title="Supervisor Overview" />
            <div className="px-4 sm:px-6 lg:px-8">
                {/* Index Summary */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-center">
                    {/* Incident Count Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Total Assigned Incidents
                        </h3>
                        <Link
                            href={route('incidents.assigned')}
                            className="text-3xl font-bold text-upei-green-500 hover:text-upei-green-600"
                        >
                            {incidentCount}
                        </Link>
                    </div>

                    {/* Unresolved Incidents Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Unresolved Assigned Incidents
                        </h3>
                        <Link
                            href={route('incidents.assigned', {
                                filters: encodeURIComponent(
                                    JSON.stringify([
                                        {
                                            column: 'status',
                                            values: [
                                                { value: IncidentStatus.ASSIGNED, comparator: '=' },
                                            ],
                                        },
                                    ])
                                ),
                            })}
                            className="text-3xl font-bold text-red-500 hover:text-red-600"
                        >
                            {unresolvedCount}
                        </Link>
                    </div>

                    {/* Resolved Incidents Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Resolved Assigned Incidents
                        </h3>
                        <Link
                            href={route('incidents.assigned', {
                                filters: encodeURIComponent(
                                    JSON.stringify([
                                        {
                                            column: 'status',
                                            values: [
                                                { value: IncidentStatus.CLOSED, comparator: '=' },
                                            ],
                                        },
                                    ])
                                ),
                            })}
                            className="text-3xl font-bold text-green-500 hover:text-green-600"
                        >
                            {closedCount}
                        </Link>
                    </div>
                </div>

                {/* Latest Incidents Table */}
                <div className="mt-8 bg-white p-6 rounded-lg shadow-lg">
                    <h3 className="text-lg font-semibold text-gray-700 mb-2 ml-2">
                        Latest Unresolved Incidents
                    </h3>
                    <OverviewTable incidents={unresolvedIncidents} />
                </div>
            </div>
        </Authenticated>
    );
}
