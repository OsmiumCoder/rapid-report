import { getIncidentRoleKey } from '@/Enums/IncidentRole';
import { getIncidentTypeKey } from '@/Enums/IncidentType';
import classNames from '@/Formatters/classNames';
import { getLocationAcronym } from '@/Helpers/Report/getLocationAcronym';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Graph from '@/Pages/Report/Partials/Graph';
import {Head, router} from '@inertiajs/react';
import { useState } from 'react';
import DateInput from "@/Components/DateInput";
import dateFormat from "@/Formatters/dateFormat";
import dayjs from "dayjs";

interface Statistic {
    labels: string[];
    entries: number[];
    title: string;
    description: string;
}

interface StatsProps {
    typeCount: number[];
    roleCount: number[];
    statusCount: number[];
    anonymousCount: number[];
    descriptorCount: number[];
    safetyCount: number[];
    environmentalCount: number[];
    securityCount: number[];
    onBehalfAnonymousCount: number[];
    onBehalfCount: number[];
    locationCount: number[];
    closedTimeCount: number[];
}

export default function Stats({
    typeCount,
    roleCount,
    statusCount,
    anonymousCount,
    descriptorCount,
    safetyCount,
    environmentalCount,
    securityCount,
    onBehalfAnonymousCount,
    onBehalfCount,
    locationCount,
    closedTimeCount,
}: StatsProps) {

    const [startDate, setStartDate] = useState(route().queryParams.start as string ?? dateFormat(dayjs().subtract(1, 'year').toDate()));

    const [endDate, setEndDate] = useState(route().queryParams.end as string ?? dateFormat(dayjs().toDate()));

    const setTimePeriod = (start: string, end: string) => {
        if (dayjs(start).isAfter(dayjs(end))) {
            end = dateFormat(dayjs(start).add(1, 'day').toDate());
        } else if (dayjs(end).isBefore(dayjs(start))) {
            start = dateFormat(dayjs(end).subtract(1, 'day').toDate());
        }

        setStartDate(start);
        setEndDate(end);

        router.get(route('report.stats', { start: start, end: end }))
    };

    const statistics: Statistic[] = [
        {
            labels: Object.keys(locationCount).map(getLocationAcronym),
            entries: Object.values(locationCount),
            title: 'Incident Location',
            description: 'Distribution of Incident Location',
        },
        {
            labels: Object.keys(closedTimeCount),
            entries: Object.values(closedTimeCount),
            title: 'Incident Time to Close',
            description: 'Distribution of Incident Close Times',
        },
        {
            labels: Object.keys(typeCount).map((x) => getIncidentTypeKey(parseInt(x))),
            entries: Object.values(typeCount),
            title: 'Incident Type',
            description: 'Distribution of Incident Type',
        },
        {
            labels: Object.keys(roleCount).map((x) => getIncidentRoleKey(parseInt(x))),
            entries: Object.values(roleCount),
            title: 'Roles',
            description: 'Distribution of Roles',
        },
        {
            labels: Object.keys(statusCount).map((x) => x.charAt(0).toUpperCase() + x.substring(1)),
            entries: Object.values(statusCount),
            title: 'Status',
            description: 'Distribution of Status',
        },
        {
            labels: ['Not Anonymous', 'Anonymous'],
            entries: anonymousCount,
            title: 'Anonymous',
            description: 'Distribution of Anonymous',
        },
        {
            labels: ['Self Reported', 'On Behalf'],
            entries: onBehalfCount,
            title: 'On Behalf',
            description: 'Distribution of On Behalf Incidents',
        },
        {
            labels: ['Self Reported Anonymous', 'Anonymous on Behalf'],
            entries: onBehalfAnonymousCount,
            title: 'On Behalf Anonymous',
            description: 'Distribution of On Behalf Anonymous Incidents',
        },
        {
            labels: Object.keys(descriptorCount),
            entries: Object.values(descriptorCount),
            title: 'Descriptor',
            description: 'Distribution of the Descriptors',
        },
        {
            labels: Object.keys(safetyCount),
            entries: Object.values(safetyCount),
            title: 'Safety types',
            description: 'Distribution of the Safety Descriptors',
        },
        {
            labels: Object.keys(environmentalCount),
            entries: Object.values(environmentalCount),
            title: 'Environment types',
            description: 'Distribution of the Environment Descriptors',
        },
        {
            labels: Object.keys(securityCount),
            entries: Object.values(securityCount),
            title: 'Security types',
            description: 'Distribution of the Security Descriptors',
        },
    ];

    const statSelections = ['Location', 'Time to Close', 'Type', 'Roles', 'Status', 'Anonymous', 'On Behalf', 'On Behalf Anonymous'];
    const descriptorSelections = ['All Descriptors', 'Safety', 'Environment', 'Security'];

    const [selectedStatistics, setSelectedStatistics] = useState([1, 2, 3, 2, 8]);

    return (
        <AuthenticatedLayout>
            <Head title="Statistics" />

            <div className="mb-10 flex w-full justify-center">
                <div className='flex w-1/2 gap-5 items-center'>
                    <DateInput
                        value={startDate}
                        onChange={(e) => {
                            setTimePeriod(dateFormat(e.target.value), endDate);
                        }}
                    />
                    <div>to</div>
                    <DateInput
                        value={endDate}
                        onChange={(e) => {
                            setTimePeriod(startDate, dateFormat(e.target.value));
                        }}
                    />
                </div>
            </div>

            <div className="mx-8 grid grid-cols-1 gap-5 lg:grid-cols-6">
                {selectedStatistics.map((selectedStatistic, i) => (
                    <div key={i} className={classNames('relative', i < 3 ? 'lg:col-span-2' : 'lg:col-span-3')}>
                        <Graph
                            labels={statistics[selectedStatistic].labels}
                            entries={statistics[selectedStatistic].entries}
                            title={statistics[selectedStatistic].title}
                            description={statistics[selectedStatistic].description}
                            statSelections={i > 2 ? descriptorSelections : statSelections}
                            onStatChange={(selectedStatistic: number) =>
                                setSelectedStatistics((prev) => [...prev.slice(0, i), selectedStatistic, ...prev.slice(i + 1)])
                            }
                            canEdit={i != 3}
                            initial={i > 2 ? 'bar' : 'pie'}
                        />
                    </div>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
