import { Incident } from '@/types/incident/Incident';
import { Link } from '@inertiajs/react';
import { nameFilter } from '@/Filters/nameFilter';
import Badge from '@/Components/Badge';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import dateFormat from '@/Filters/dateFormat';

export default function OverviewTable({ incidents }: { incidents: Incident[] }) {
    return (
        <table className="min-w-full mt-4 table-auto">
            <thead>
                <tr>
                    <th className="px-4 py-2 text-left">Reported By</th>
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
                        <td className="px-4 py-2">
                            {nameFilter(incident)[0]} {nameFilter(incident)[1]}
                        </td>
                        <td className="px-4 py-2">{incident.description ?? 'None Provided'}</td>
                        <td className="px-4 py-2">
                            <Badge
                                color={incidentBadgeColor(incident)}
                                text={uppercaseWordFormat(incident.status)}
                            />
                        </td>
                        <td className="px-4 py-2">{dateFormat(incident.created_at)}</td>
                        <td className="px-4 py-2">
                            <Link
                                href={route('incidents.show', {
                                    incident: incident.id,
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
    );
}
