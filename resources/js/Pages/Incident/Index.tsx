import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link } from '@inertiajs/react';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/20/solid';
import { Incident } from '@/types/Incident';
import { PaginatedResponse } from '@/types/PaginatedResponse';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import { PencilIcon } from '@heroicons/react/24/outline';

type IndexType = 'owned' | 'assigned' | 'all';

interface IndexProps {
    incidents: PaginatedResponse<Incident>;
    indexType: IndexType;
}

export default function Index({ incidents, indexType }: IndexProps) {
    const pageDescriptions: {
        [K in IndexType]: { title: string; description: string };
    } = {
        all: {
            title: 'All Incidents',
            description: 'A list of all incidents reported in the system.',
        },
        assigned: {
            title: 'Assigned Incidents',
            description: 'A list of all incidents assigned to you for review.',
        },
        owned: {
            title: 'Owned Incidents',
            description: 'A list of all incidents submitted by you.',
        },
    };

    return (
        <AuthenticatedLayout>
            <Head title="Incidents" />
            <div className="px-4 sm:px-6 lg:px-8">
                <div className="sm:flex sm:items-center">
                    <div className="sm:flex-auto">
                        <h1 className="text-base font-semibold text-gray-900">
                            {pageDescriptions[indexType].title}
                        </h1>
                        <p className="mt-2 text-sm text-gray-700">
                            {pageDescriptions[indexType].description}
                        </p>
                    </div>
                    {indexType === 'owned' && (
                        <div className="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <Link
                                href={route('incidents.create')}
                                as="button"
                                className="flex items-center rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                <PencilIcon className="h-4 w-4 mr-2" />
                                Submit Incident
                            </Link>
                        </div>
                    )}
                </div>
                <div className="mt-8 flow-root">
                    <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div className="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                                <table className="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th
                                                scope="col"
                                                className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <span className="sm:block md:hidden">
                                                    Incident
                                                </span>
                                                <span className="hidden md:inline-block">
                                                    Reporter
                                                </span>
                                            </th>
                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                Descriptor
                                            </th>
                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                Location
                                            </th>
                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                Date
                                            </th>
                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                Status
                                            </th>
                                            <th
                                                scope="col"
                                                className="relative py-3.5 pl-3 pr-4 md:pr-6"
                                            >
                                                <span className="sr-only">
                                                    View
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-200 bg-white">
                                        {incidents.data.map((incident) => (
                                            <Link
                                                as="tr"
                                                className="cursor-pointer hover:bg-gray-50"
                                                href={route('incidents.show', {
                                                    incident: incident.id,
                                                })}
                                                key={incident.id}
                                            >
                                                <td className="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 md:w-auto md:max-w-none md:pl-6">
                                                    {`${incident.first_name}\n${incident.last_name}`}
                                                    <dl className="font-normal md:hidden">
                                                        <dt className="sr-only">
                                                            Descriptor
                                                        </dt>
                                                        <dd className="mt-1 truncate text-gray-700 sm:hidden">
                                                            {
                                                                incident.descriptor
                                                            }
                                                        </dd>
                                                        <dt className="sr-only sm:hidden">
                                                            Status
                                                        </dt>
                                                        <dd className="mt-1 truncate text-gray-500 sm:hidden">
                                                            {incident.status ===
                                                            IncidentStatus.OPEN
                                                                ? 'Open'
                                                                : 'Closed'}
                                                        </dd>
                                                        <dt className="sr-only sm:hidden">
                                                            Date
                                                        </dt>
                                                        <dd className="mt-1 truncate text-gray-500 sm:hidden">
                                                            {new Date(
                                                                incident.happened_at
                                                            ).toLocaleDateString()}
                                                        </dd>
                                                    </dl>
                                                </td>
                                                <td className="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                    {incident.descriptor}
                                                </td>
                                                <td className="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                    {incident.location}
                                                </td>
                                                <td className="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                    {new Date(
                                                        incident.happened_at
                                                    ).toLocaleDateString()}
                                                </td>
                                                <td className="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                    {incident.status === 1
                                                        ? IncidentStatus.OPEN
                                                        : IncidentStatus.CLOSED}
                                                </td>
                                                <td className="py-4 pl-3 pr-4 text-right text-sm font-medium md:pr-6">
                                                    <Link
                                                        href={route(
                                                            'incidents.show',
                                                            {
                                                                incident:
                                                                    incident.id,
                                                            }
                                                        )}
                                                        className="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        View
                                                        <span className="sr-only">
                                                            ,{' '}
                                                            {
                                                                incident.descriptor
                                                            }
                                                        </span>
                                                    </Link>
                                                </td>
                                            </Link>
                                        ))}
                                    </tbody>
                                </table>
                                <div className="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 md:px-6">
                                    <div className="flex flex-1 justify-between sm:hidden">
                                        <Link
                                            href={
                                                incidents.prev_page_url || '#'
                                            }
                                            className={`relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 ${
                                                !incidents.prev_page_url
                                                    ? 'cursor-not-allowed opacity-50'
                                                    : ''
                                            }`}
                                        >
                                            Previous
                                        </Link>
                                        <Link
                                            href={
                                                incidents.next_page_url || '#'
                                            }
                                            className={`relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 ${
                                                !incidents.next_page_url
                                                    ? 'cursor-not-allowed opacity-50'
                                                    : ''
                                            }`}
                                        >
                                            Next
                                        </Link>
                                    </div>
                                    <div className="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                                        <div>
                                            <p className="text-sm text-gray-700">
                                                Showing{' '}
                                                <span className="font-medium">
                                                    {incidents.from}
                                                </span>{' '}
                                                to{' '}
                                                <span className="font-medium">
                                                    {incidents.to}
                                                </span>{' '}
                                                of{' '}
                                                <span className="font-medium">
                                                    {incidents.total}
                                                </span>{' '}
                                                results
                                            </p>
                                        </div>
                                        <div>
                                            <nav
                                                aria-label="Pagination"
                                                className="isolate inline-flex -space-x-px rounded-md shadow-sm"
                                            >
                                                <Link
                                                    href={
                                                        incidents.prev_page_url ||
                                                        '#'
                                                    }
                                                    className={`relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 ${
                                                        !incidents.prev_page_url
                                                            ? 'cursor-not-allowed opacity-50'
                                                            : ''
                                                    }`}
                                                >
                                                    <ChevronLeftIcon
                                                        className="h-5 w-5"
                                                        aria-hidden="true"
                                                    />
                                                </Link>

                                                {incidents.links.map(
                                                    (link, index) =>
                                                        isNaN(
                                                            Number(link.label)
                                                        ) ? null : (
                                                            <Link
                                                                key={index}
                                                                href={
                                                                    link.url ||
                                                                    '#'
                                                                }
                                                                className={`relative inline-flex items-center px-4 py-2 text-sm font-semibold ${
                                                                    link.active
                                                                        ? 'z-10 bg-indigo-600 text-white focus:z-20 focus:outline-offset-0'
                                                                        : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0'
                                                                }`}
                                                            >
                                                                {link.label}
                                                            </Link>
                                                        )
                                                )}
                                                <Link
                                                    href={
                                                        incidents.next_page_url ||
                                                        '#'
                                                    }
                                                    className={`relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 ${
                                                        !incidents.next_page_url
                                                            ? 'cursor-not-allowed opacity-50'
                                                            : ''
                                                    }`}
                                                >
                                                    <ChevronRightIcon
                                                        className="h-5 w-5"
                                                        aria-hidden="true"
                                                    />
                                                </Link>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
