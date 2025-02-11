import { Incident } from '@/types/incident/Incident';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import OverviewTable from '@/Pages/Dashboard/Partials/OverviewTable';

interface SupervisorDashboardProps {
    incidents: Incident[];
    incidentCount: number;
    closedCount: number;
    unresolvedCount: number;
}

export default function SupervisorOverview({
    incidents,
    incidentCount,
    closedCount,
    unresolvedCount,
}: SupervisorDashboardProps) {
    return (
        <Authenticated>
            <div className="container mx-auto py-8">
                {/* Index Summary */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {/* Incident Count Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Total Assigned Incidents
                        </h3>
                        <p className="text-3xl font-bold text-upei-green-600">{incidentCount}</p>
                    </div>

                    {/* Resolved Incidents Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Resolved Assigned Incidents
                        </h3>
                        <p className="text-3xl font-bold text-green-500">{closedCount}</p>
                    </div>

                    {/* Unresolved Incidents Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Unresolved Assigned Incidents
                        </h3>
                        <p className="text-3xl font-bold text-red-500">{unresolvedCount}</p>
                    </div>
                </div>

                {/* Latest Incidents Table */}
                <div className="mt-8 bg-white p-6 rounded-lg shadow-lg">
                    <h3 className="text-lg font-semibold text-gray-700">
                        Latest Assigned Incidents
                    </h3>
                    <OverviewTable incidents={incidents} />
                </div>
            </div>
        </Authenticated>
    );
}
