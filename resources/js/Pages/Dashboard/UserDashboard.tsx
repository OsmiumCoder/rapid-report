import { Link, usePage } from '@inertiajs/react';
import { Incident } from '@/types/incident/Incident';
import Badge from '@/Components/Badge';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import dateFormat from '@/Filters/dateFormat';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import {PencilIcon} from "@heroicons/react/24/outline";

interface UserDashboardProps {
    incidents: Incident[];
    incidentCount: number;
    unresolvedCount: number;
}

export default function UserDashboard({
    incidents,
    incidentCount,
    unresolvedCount,
}: UserDashboardProps) {
    const { user } = usePage().props.auth;
    return (
        <Authenticated>
            <div className="px-4 sm:px-6 lg:px-8">
                <div className="bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h2 className="text-2xl font-semibold text-gray-700">Welcome, {user.name}!</h2>
                    <p className="mt-2 text-lg text-gray-600">
                        Here's a quick overview of your submitted incidents and their status.
                    </p>
                </div>
                {/* Dashboard Summary */}
                <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {/* Incident Count Card */}
                    <div className="flex justify-around bg-white p-6 rounded-lg shadow-lg">
                        <div className="flex flex-col items-center justify-center text-center">
                            <h3 className="text-lg font-semibold text-gray-700">
                                Your Submitted Incidents
                            </h3>
                            <p className="text-3xl font-bold text-upei-green-600">{incidentCount}</p>
                        </div>
                        <div className="flex flex-col items-center justify-center text-center">
                            <h3 className="text-lg font-semibold text-gray-700">
                                Your Unresolved Incidents
                            </h3>
                            <p className="text-3xl font-bold text-red-500">{unresolvedCount}</p>
                        </div>
                    </div>

                    {/* Report New Incident Card */}
                    <div className="bg-white p-6 rounded-lg shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">
                            Report a New Incident
                        </h3>
                        <p className="text-base text-gray-700">
                            Quickly report any health, safety or environmental incidents you
                            encounter.
                        </p>
                        <div className="flex justify-evenly mt-6">
                            <Link
                                href={route('incidents.create')}
                                as="button"
                                className="flex items-center rounded-md bg-upei-green-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-upei-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600"
                            >
                                <PencilIcon className="h-4 w-4 mr-2" />
                                Submit Incident
                            </Link>
                            <Link
                                href={route('incidents.owned')}
                                as="button"
                                className="flex items-center rounded-md bg-upei-green-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-upei-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600"
                            >
                                View Submitted Incidents
                            </Link>
                        </div>
                    </div>
                </div>

                {/* User's Reported Incidents Table */}
                <div className="mt-8 bg-white p-2 md:p-6 rounded-lg shadow-lg">
                    <h3 className="text-lg font-semibold text-gray-700 text-center md:text-left">
                        Your Latest Incidents
                    </h3>
                    {incidents.length === 0 ? (
                        <div className="text-center">You have no reported incidents</div>
                    ) : (
                        <table className="min-w-full mt-4 table-auto">
                            <thead>
                                <tr>
                                    <th className="px-4 py-2 text-left">Description</th>
                                    <th className="px-4 py-2 text-center">Status</th>
                                    <th className="px-4 py-2 text-center">Reported</th>
                                </tr>
                            </thead>
                            <tbody>
                                {incidents.map((incident) => (
                                    <Link
                                        as="tr"
                                        key={incident.id}
                                        href={route('incidents.show', { incident: incident.id })}
                                        className="hover:cursor-pointer"
                                    >
                                        <td className="px-4 py-2">{incident.description}</td>
                                        <td className="px-4 py-2">
                                            <Badge
                                                color={incidentBadgeColor(incident)}
                                                text={uppercaseWordFormat(incident.status)}
                                            />
                                        </td>
                                        <td className="px-4 py-2">
                                            {dateFormat(incident.created_at)}
                                        </td>
                                        <td className="px-4 py-2 hidden md:block">
                                            <Link
                                                href={route('incidents.show', {
                                                    incident: incident.id,
                                                })}
                                                className="text-upei-green-500 hover:text-upei-green-600"
                                            >
                                                View
                                                <span className="sr-only">
                                                    , {incident.descriptor}
                                                </span>
                                            </Link>
                                        </td>
                                    </Link>
                                ))}
                            </tbody>
                        </table>
                    )}
                </div>
            </div>
        </Authenticated>
    );
}
