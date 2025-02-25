import Badge from '@/Components/Badge';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import dateFormat from '@/Filters/dateFormat';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { Incident } from '@/types/incident/Incident';
import { PencilIcon } from '@heroicons/react/24/outline';
import { Head, Link, usePage } from '@inertiajs/react';

interface UserDashboardProps {
    incidents: Incident[];
    incidentCount: number;
    unresolvedCount: number;
}

export default function UserDashboard({ incidents, incidentCount, unresolvedCount }: UserDashboardProps) {
    const { user } = usePage().props.auth;
    return (
        <Authenticated>
            <Head title="Dashboard" />
            <div className="px-4 sm:px-6 lg:px-8">
                <div className="mb-8 rounded-lg bg-white p-6 shadow-lg">
                    <h2 className="text-2xl font-semibold text-gray-700">Welcome, {user.name}!</h2>
                    <p className="mt-2 text-lg text-gray-600">Here's a quick overview of your submitted incidents and their status.</p>
                </div>
                {/* Dashboard Summary */}
                <div className="grid grid-cols-1 gap-6 md:grid-cols-2">
                    {/* Incident Count Card */}
                    <div className="flex justify-around rounded-lg bg-white p-6 shadow-lg">
                        <div className="flex flex-col items-center justify-center text-center">
                            <h3 className="text-lg font-semibold text-gray-700">Your Submitted Incidents</h3>
                            <Link href={route('incidents.owned')} className="text-upei-green-500 hover:text-upei-green-600 text-3xl font-bold">
                                {incidentCount}
                            </Link>
                        </div>
                        <div className="flex flex-col items-center justify-center text-center">
                            <h3 className="text-lg font-semibold text-gray-700">Your Unresolved Incidents</h3>
                            <Link
                                href={route('incidents.owned', {
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
                    </div>

                    {/* Report New Incident Card */}
                    <div className="rounded-lg bg-white p-6 shadow-lg">
                        <h3 className="text-lg font-semibold text-gray-700">Report a New Incident</h3>
                        <p className="text-base text-gray-700">Quickly report any health, safety or environmental incidents you encounter.</p>
                        <div className="mt-6 flex h-24 flex-col justify-evenly gap-x-4 sm:h-auto sm:flex-row">
                            <Link
                                href={route('incidents.create')}
                                as="button"
                                className="bg-upei-green-500 hover:bg-upei-green-400 focus-visible:outline-upei-green-600 flex items-center justify-center rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                <PencilIcon className="mr-2 h-4 w-4" />
                                Submit Incident
                            </Link>
                            <Link
                                href={route('incidents.owned')}
                                as="button"
                                className="bg-upei-green-500 hover:bg-upei-green-400 focus-visible:outline-upei-green-600 flex items-center justify-center rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                            >
                                View Submitted Incidents
                            </Link>
                        </div>
                    </div>
                </div>

                {/* User's Reported Incidents Table */}
                <div className="mt-8 rounded-lg bg-white p-2 shadow-lg md:p-6">
                    <h3 className="mb-2 ml-2 text-center text-lg font-semibold text-gray-700 md:text-left">Your Latest Incidents</h3>
                    {incidents.length === 0 ? (
                        <div className="text-center">You have no reported incidents</div>
                    ) : (
                        <div className="flow-root">
                            <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div className="overflow-hidden shadow-sm ring-1 ring-black/5 sm:rounded-lg">
                                        <table className="min-w-full divide-y divide-gray-300">
                                            <thead>
                                                <tr>
                                                    <th scope="col" className="w-3/5 px-4 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Description
                                                    </th>
                                                    <th scope="col" className="px-4 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                        Status
                                                    </th>
                                                    <th scope="col" className="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">
                                                        Reported
                                                    </th>
                                                    <th scope="col" className="py-3.5 pr-4 pl-3 md:pr-6">
                                                        <span className="sr-only">View</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody className="divide-y divide-gray-200 bg-white">
                                                {incidents.map((incident) => (
                                                    <Link
                                                        as="tr"
                                                        className="cursor-pointer hover:bg-gray-50"
                                                        href={route('incidents.show', {
                                                            incident: incident.slug,
                                                        })}
                                                        key={incident.slug}
                                                    >
                                                        <td className="w-[70rem] px-3 py-4 text-sm text-gray-500">
                                                            <div className="line-clamp-3">{incident.description}</div>
                                                        </td>
                                                        <td className="px-3 py-4 text-center text-sm">
                                                            <Badge color={incidentBadgeColor(incident)} text={uppercaseWordFormat(incident.status)} />
                                                        </td>
                                                        <td className="px-3 py-4 text-center text-sm text-gray-500">
                                                            {dateFormat(incident.created_at)}
                                                        </td>
                                                        <td className="py-4 pr-4 pl-3 text-right text-sm font-medium md:pr-6">
                                                            <Link
                                                                href={route('incidents.show', {
                                                                    incident: incident.slug,
                                                                })}
                                                                className="text-upei-green-500 hover:text-upei-green-600"
                                                            >
                                                                View
                                                                <span className="sr-only">, {incident.descriptor}</span>
                                                            </Link>
                                                        </td>
                                                    </Link>
                                                ))}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    )}
                </div>
            </div>
        </Authenticated>
    );
}
