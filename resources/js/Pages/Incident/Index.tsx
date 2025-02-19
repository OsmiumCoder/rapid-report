import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, router } from '@inertiajs/react';
import {
    ChevronDownIcon,
    ChevronUpIcon,
    ChevronLeftIcon,
    ChevronRightIcon,
} from '@heroicons/react/20/solid';
import { Incident } from '@/types/incident/Incident';
import { PaginatedResponse } from '@/types/PaginatedResponse';
import { PencilIcon } from '@heroicons/react/24/outline';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { nameFilter } from '@/Filters/nameFilter';
import IndexFilter from '@/Pages/Incident/Partials/IndexComponents/IndexFilter';
import { MouseEventHandler, useEffect, useRef, useState } from 'react';
import classNames from '@/Filters/classNames';
import { descriptors } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import Badge from '@/Components/Badge';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';
import Pagination from '@/Components/Pagination';
import { sortBy } from 'underscore';

type IndexType = 'owned' | 'assigned' | 'all';

export type FilterValue = 'descriptor' | 'incident_type' | 'status' | 'created_at';

type Comparator = '<' | '>' | '<=' | '>=' | '=';

export interface Filter {
    value: string;
    label: string;
    checked: boolean;
    comparator: Comparator;
}

interface ProcessedFilter {
    column: FilterValue;
    values: { value: string; comparator: Comparator }[];
}

interface IndexProps {
    incidents: PaginatedResponse<Incident>;
    indexType: IndexType;
    currentFilters?: ProcessedFilter[];
    currentSortBy?: SortBy;
    currentSortDirection?: SortDirection;
}

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

type SortDirection = 'asc' | 'desc';
type SortBy = 'name' | 'descriptor' | 'location' | 'created_at' | 'status';

const initialFilters = {
    incident_type: descriptors.map(({ name, value }) => ({
        label: name,
        value: value.toString(),
        checked: false,
        comparator: '=',
    })),
    descriptor: descriptors
        .flatMap((item) => item.options)
        .map((descriptor) => ({
            label: descriptor,
            value: descriptor,
            checked: false,
            comparator: '=',
        }))
        // Keep only the first occurrence of each descriptor
        .filter(
            (value, index, self) => self.findIndex((item) => item.value === value.value) === index
        ) as Filter[],
    status: Object.values(IncidentStatus).map((status) => ({
        label: uppercaseWordFormat(status.toString()),
        value: status.toString(),
        checked: false,
        comparator: '=',
    })),
    created_at: [
        {
            label: 'From',
            value: '',
            checked: false,
            comparator: '>=',
        },
        {
            label: 'To',
            value: '',
            checked: false,
            comparator: '<=',
        },
    ],
} as Record<FilterValue, Filter[]>;

const getInitialFilters: (currentFilters: ProcessedFilter[]) => Record<FilterValue, Filter[]> = (
    currentFilters
) => {
    const newFilters = structuredClone(initialFilters) as Record<FilterValue, Filter[]>;

    currentFilters.forEach((filter) => {
        if (newFilters[filter.column]) {
            newFilters[filter.column] = newFilters[filter.column].map((newFilter) =>
                filter.values.some(({ value }) => value === newFilter.value)
                    ? { ...newFilter, checked: true }
                    : newFilter
            );
        }
    });

    return newFilters;
};

export default function Index({
    incidents,
    indexType,
    currentFilters,
    currentSortBy,
    currentSortDirection,
}: IndexProps) {
    const hasMounted = useRef(false);

    const [filters, setFilters] = useState<Record<FilterValue, Filter[]>>(
        getInitialFilters(currentFilters ?? [])
    );

    const [sortedBy, setSortedBy] = useState<SortBy>(currentSortBy ?? 'created_at');

    const [sortedDirection, setSortedDirection] = useState<SortDirection>(
        currentSortDirection ?? 'desc'
    );

    const resetFilters = () => setFilters(initialFilters);

    const handleSortCycle = (sortBy: SortBy) => {
        if (sortBy !== sortedBy || sortedDirection === 'desc') {
            setSortedDirection('asc');
        } else {
            setSortedDirection('desc');
        }

        setSortedBy(sortBy);
    };

    const handleSort = (e: MouseEvent, sortBy: SortBy, sortDirection: SortDirection) => {
        e.stopPropagation();
        if (sortBy === sortedBy && sortDirection === sortedDirection) return;

        setSortedBy(sortBy);
        setSortedDirection(sortDirection);
    };

    useEffect(() => {
        // Do not sort and filter on initial render
        if (hasMounted.current) {
            handleSortAndFilter();
        } else {
            hasMounted.current = true;
        }
    }, [filters, sortedDirection, sortedBy]);

    const handleSortAndFilter = () => {
        const processedFilters = Object.entries(filters).reduce<ProcessedFilter[]>(
            (acc, [key, value]) => {
                const checkedValues = value
                    .filter((filter) => filter.checked)
                    .map((filter) => ({
                        value: filter.value,
                        comparator: filter.comparator,
                    }));

                if (checkedValues.length > 0) {
                    acc.push({
                        column: key as FilterValue,
                        values: checkedValues,
                    });
                }
                return acc;
            },
            []
        );

        router.get(
            route(`incidents.${indexType === 'all' ? 'index' : indexType}`),
            {
                filters: encodeURIComponent(JSON.stringify(processedFilters)),
                sort_by: sortedBy,
                sort_direction: sortedDirection,
            },
            {
                preserveState: true,
                only: ['incidents'],
            }
        );
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
                                className="flex items-center rounded-md bg-upei-green-500 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-upei-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600"
                            >
                                <PencilIcon className="h-4 w-4 mr-2" />
                                Submit Incident
                            </Link>
                        </div>
                    )}
                </div>
                <IndexFilter
                    filters={filters}
                    setFilters={setFilters}
                    resetFilters={resetFilters}
                />
                <div className="flow-root">
                    <div className="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div className="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div className="overflow-hidden shadow ring-1 ring-black/5 sm:rounded-lg">
                                <table className="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th
                                                scope="col"
                                                className="hidden px-6 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                <div
                                                    onClick={() => handleSortCycle('created_at')}
                                                    className="flex items-center hover:cursor-pointer select-none"
                                                >
                                                    Submitted On
                                                    <div className="ml-2 rounded text-gray-400 group-hover:visible group-focus:visible">
                                                        <ChevronUpIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'created_at',
                                                                    'asc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pt-1',
                                                                sortedDirection === 'asc' &&
                                                                    sortedBy === 'created_at'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                        <ChevronDownIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'created_at',
                                                                    'desc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pb-1',
                                                                sortedDirection === 'desc' &&
                                                                    sortedBy === 'created_at'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </th>
                                            <th
                                                scope="col"
                                                className="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                            >
                                                <div
                                                    onClick={() => handleSortCycle('name')}
                                                    className="flex items-center hover:cursor-pointer select-none"
                                                >
                                                    <div>
                                                        <span className="sm:block md:hidden">
                                                            Incident
                                                        </span>
                                                        <span className="hidden md:inline-block">
                                                            Reporter
                                                        </span>
                                                    </div>
                                                    <div className="ml-2 rounded text-gray-400 group-hover:visible group-focus:visible">
                                                        <ChevronUpIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'name',
                                                                    'asc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pt-1',
                                                                sortedDirection === 'asc' &&
                                                                    sortedBy === 'name'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                        <ChevronDownIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'name',
                                                                    'desc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pb-1',
                                                                sortedDirection === 'desc' &&
                                                                    sortedBy === 'name'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </th>
                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                <div
                                                    onClick={() => handleSortCycle('descriptor')}
                                                    className="flex items-center hover:cursor-pointer select-none"
                                                >
                                                    Descriptor
                                                    <div className="ml-2 rounded text-gray-400 group-hover:visible group-focus:visible">
                                                        <ChevronUpIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'descriptor',
                                                                    'asc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pt-1',
                                                                sortedDirection === 'asc' &&
                                                                    sortedBy === 'descriptor'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                        <ChevronDownIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'descriptor',
                                                                    'desc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pb-1',
                                                                sortedDirection === 'desc' &&
                                                                    sortedBy === 'descriptor'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </th>
                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                <div
                                                    onClick={() => handleSortCycle('location')}
                                                    className="flex items-center hover:cursor-pointer select-none"
                                                >
                                                    Location
                                                    <div className="ml-2 rounded text-gray-400 group-hover:visible group-focus:visible">
                                                        <ChevronUpIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'location',
                                                                    'asc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pt-1',
                                                                sortedDirection === 'asc' &&
                                                                    sortedBy === 'location'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                        <ChevronDownIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'location',
                                                                    'desc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pb-1',
                                                                sortedDirection === 'desc' &&
                                                                    sortedBy === 'location'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </th>

                                            <th
                                                scope="col"
                                                className="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell"
                                            >
                                                <div
                                                    onClick={() => handleSortCycle('status')}
                                                    className="flex items-center hover:cursor-pointer select-none"
                                                >
                                                    Status
                                                    <div className="ml-2 rounded text-gray-400 group-hover:visible group-focus:visible">
                                                        <ChevronUpIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'status',
                                                                    'asc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pt-1',
                                                                sortedDirection === 'asc' &&
                                                                    sortedBy === 'status'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                        <ChevronDownIcon
                                                            aria-hidden="true"
                                                            onClick={(e) =>
                                                                handleSort(
                                                                    e as unknown as MouseEvent,
                                                                    'status',
                                                                    'desc'
                                                                )
                                                            }
                                                            className={classNames(
                                                                'size-5 pb-1',
                                                                sortedDirection === 'desc' &&
                                                                    sortedBy === 'status'
                                                                    ? 'text-gray-900'
                                                                    : 'text-gray-400'
                                                            )}
                                                        />
                                                    </div>
                                                </div>
                                            </th>
                                            <th
                                                scope="col"
                                                className="relative py-3.5 pl-3 pr-4 md:pr-6"
                                            >
                                                <span className="sr-only">View</span>
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
                                                <td className="hidden px-6 py-4 text-sm text-gray-500 md:table-cell">
                                                    {new Date(
                                                        incident.created_at
                                                    ).toLocaleDateString()}
                                                </td>
                                                <td className="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 md:w-auto md:max-w-none md:pl-6">
                                                    {`${nameFilter(incident)[0]} ${nameFilter(incident)[1]}`}
                                                    <dl className="font-normal md:hidden">
                                                        <dt className="sr-only">Descriptor</dt>
                                                        <dd className="mt-1 truncate text-gray-700 sm:hidden">
                                                            {incident.descriptor}
                                                        </dd>
                                                        <dt className="sr-only sm:hidden">
                                                            Status
                                                        </dt>
                                                        <dd className="mt-1 truncate text-gray-500 sm:hidden">
                                                            {uppercaseWordFormat(incident.status)}
                                                        </dd>
                                                        <dt className="sr-only sm:hidden">Date</dt>
                                                        <dd className="mt-1 truncate text-gray-500 sm:hidden">
                                                            {new Date(
                                                                incident.created_at
                                                            ).toLocaleDateString()}
                                                        </dd>
                                                    </dl>
                                                </td>
                                                <td className="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                    {incident.descriptor}
                                                </td>
                                                <td className="px-3 py-4 text-sm text-gray-500 md:table-cell">
                                                    {incident.location ?? 'Not Provided'}
                                                </td>
                                                <td className="hidden px-3 py-4 text-sm md:table-cell">
                                                    <Badge
                                                        color={incidentBadgeColor(incident)}
                                                        text={uppercaseWordFormat(incident.status)}
                                                    />
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

                                <Pagination pagination={incidents} />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
