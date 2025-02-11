import { Head, Link } from '@inertiajs/react';
import { Incident } from '@/types/incident/Incident';
import Badge from '@/Components/Badge';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { nameFilter } from '@/Filters/nameFilter';
import dateFormat from '@/Filters/dateFormat';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import OverviewTable from '@/Pages/Dashboard/Partials/OverviewTable';

interface AdminDashboardProps {
    incidents: Incident[];
    incidentCount: number;
    closedCount: number;
    unresolvedCount: number;
}

export default function AdminOverview({
    incidents,
    incidentCount,
    closedCount,
    unresolvedCount,
}: AdminDashboardProps) {
    return (
        <Authenticated>
            <div className="px-4 sm:px-6 lg:px-8">
                {/* Index Summary */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {/* Incident Count Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">Total Incidents</h3>
                        <p className="text-3xl font-bold text-upei-green-600">{incidentCount}</p>
                    </div>

                    {/* Unresolved Incidents Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Unresolved Incidents
                        </h3>
                        <p className="text-3xl font-bold text-red-500">{unresolvedCount}</p>
                    </div>

                    {/* Resolved Incidents Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">Resolved Incidents</h3>
                        <p className="text-3xl font-bold text-green-500">{closedCount}</p>
                    </div>
                </div>

                {/* Latest Incidents Table */}
                <div className="mt-8 bg-white p-6 rounded-lg shadow-lg">
                    <h3 className="text-lg font-semibold text-gray-700">Latest Incidents</h3>
                    <OverviewTable incidents={incidents} />
                </div>
            </div>
        </Authenticated>
    );
}
