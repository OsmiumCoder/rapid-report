import { Incident } from '@/types/incident/Incident';
import { Link } from '@inertiajs/react';
import { nameFilter } from '@/Filters/nameFilter';
import Badge from '@/Components/Badge';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import dateFormat from '@/Filters/dateFormat';

export default function OverviewTable({ incidents }: { incidents: Incident[] }) {
    return (
        <div className="flow-root">
            <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div className="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                        <table className="min-w-full divide-y divide-gray-300">
                            <thead>
                                <tr>
                                    <th
                                        scope="col"
                                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 "
                                    >
                                        Reporter
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 "
                                    >
                                        Description
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-4 py-3.5 text-left text-sm font-semibold text-gray-900 "
                                    >
                                        Status
                                    </th>
                                    <th
                                        scope="col"
                                        className="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                    >
                                        Reported
                                    </th>
                                    <th scope="col" className="py-3.5 pl-3 pr-4 md:pr-6">
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
                                            incident: incident.id,
                                        })}
                                        key={incident.id}
                                    >
                                        <td className="px-3 py-4 text-sm text-gray-500 ">
                                            {nameFilter(incident)[0]} {nameFilter(incident)[1]}
                                        </td>

                                        <td className="px-3 py-4 text-sm w-[65rem] text-gray-500 ">
                                            <div className="w-full line-clamp-3">
                                                {incident.description}
                                            </div>
                                        </td>
                                        <td className="px-3 py-4 text-sm">
                                            <Badge
                                                color={incidentBadgeColor(incident)}
                                                text={uppercaseWordFormat(incident.status)}
                                            />
                                        </td>
                                        <td className="px-3 py-4 text-sm text-gray-500">
                                            {dateFormat(incident.created_at)}
                                        </td>
                                        <td className="py-4 pl-3 pr-4 text-right text-sm font-medium md:pr-6">
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
                    </div>
                </div>
            </div>
        </div>
    );
}
