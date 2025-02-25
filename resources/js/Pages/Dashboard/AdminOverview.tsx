import { IncidentStatus } from '@/Enums/IncidentStatus';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import OverviewTable from '@/Pages/Dashboard/Partials/OverviewTable';
import { Incident } from '@/types/incident/Incident';
import { Head, Link } from '@inertiajs/react';

interface AdminDashboardProps {
    incidents: Incident[];
    incidentCount: number;
    closedCount: number;
    unresolvedCount: number;
}

export default function AdminOverview({ incidents, incidentCount, closedCount, unresolvedCount }: AdminDashboardProps) {
    return (
        <Authenticated>
            <Head title="Admin Overview" />
            <div className="px-4 sm:px-6 lg:px-8">
                {/* Index Summary */}
                <div className="grid grid-cols-1 gap-6 text-center md:grid-cols-2 lg:grid-cols-3">
                    {/* Incident Count Card */}
                    <div className="rounded-lg bg-white p-6 shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">Total Incidents</h3>
                        <Link href={route('incidents.index')} className="text-upei-green-500 hover:text-upei-green-600 text-3xl font-bold">
                            {incidentCount}
                        </Link>
                    </div>

                    {/* Unresolved Incidents Card */}
                    <div className="rounded-lg bg-white p-6 shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">Unresolved Incidents</h3>
                        <Link
                            href={route('incidents.index', {
                                filters: encodeURIComponent(
                                    JSON.stringify([
                                        {
                                            column: 'status',
                                            values: [
                                                {
                                                    value: IncidentStatus.OPENED,
                                                    comparator: '=',
                                                },
                                                {
                                                    value: IncidentStatus.ASSIGNED,
                                                    comparator: '=',
                                                },
                                                {
                                                    value: IncidentStatus.IN_REVIEW,
                                                    comparator: '=',
                                                },
                                                {
                                                    value: IncidentStatus.REOPENED,
                                                    comparator: '=',
                                                },
                                                {
                                                    value: IncidentStatus.RETURNED,
                                                    comparator: '=',
                                                },
                                            ],
                                        },
                                    ]),
                                ),
                            })}
                            className="text-3xl font-bold text-red-500 hover:text-red-600"
                        >
                            {unresolvedCount}
                        </Link>
                    </div>

                    {/* Resolved Incidents Card */}
                    <div className="rounded-lg bg-white p-6 shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">Resolved Incidents</h3>
                        <Link
                            href={route('incidents.index', {
                                filters: encodeURIComponent(
                                    JSON.stringify([
                                        {
                                            column: 'status',
                                            values: [
                                                {
                                                    value: IncidentStatus.CLOSED,
                                                    comparator: '=',
                                                },
                                            ],
                                        },
                                    ]),
                                ),
                            })}
                            className="text-3xl font-bold text-green-500 hover:text-green-600"
                        >
                            {closedCount}
                        </Link>
                    </div>
                </div>

                {/* Latest Incidents Table */}
                <div className="mt-8 rounded-lg bg-white p-6 shadow-lg">
                    <h3 className="mb-2 ml-2 text-lg font-semibold text-gray-700">Latest Incidents</h3>
                    <OverviewTable incidents={incidents} />
                </div>
            </div>
        </Authenticated>
    );
}
