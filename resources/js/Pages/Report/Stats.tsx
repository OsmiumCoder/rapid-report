import classNames from '@/Formatters/classNames';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Graph from '@/Pages/Report/Partials/Graph';
import { useState } from 'react';
import { Head } from '@inertiajs/react';

interface dataEntry {
    labels: string[];
    entries: number[];
    entries_number: number;
    title: string;
    description: string;
}
export default function Stats({
    type_dist,
    witnesses_dist,
    role_dist,
    status_dist,
    anon_dist,
    descriptor_dist,
    safety_dist,
    environmental_dist,
    security_dist,
    on_behalf_anon_dist,
    on_behalf_dist,
}: {
    type_dist: number[];
    witnesses_dist: number[];
    role_dist: number[];
    status_dist: number[];
    anon_dist: number[];
    descriptor_dist: number[];
    safety_dist: number[];
    environmental_dist: number[];
    security_dist: number[];
    on_behalf_anon_dist: number[];
    on_behalf_dist: number[];
}) {
    const type_label_key = {
        1: 'Safety',
        2: 'Environmental',
        3: 'Security',
    };

    const role_label_key = {
        1: 'Employee',
        2: 'Student',
        3: 'Visitor',
        4: 'Contractor',
    };

    const data: dataEntry[] = [
        {
            labels: Object.keys(type_dist).map((x) => type_label_key[parseInt(x) as keyof typeof type_label_key]),
            entries: Object.values(type_dist),
            entries_number: type_dist.length,
            title: 'Incident Type',
            description: 'Distribution of Incident Type',
        },
        {
            labels: Object.keys(witnesses_dist),
            entries: Object.values(witnesses_dist),
            entries_number: Object.keys(witnesses_dist).length,
            title: 'Witness Counts',
            description: 'Distribution of Witnesses per Incident',
        },
        {
            labels: Object.keys(role_dist).map((x) => role_label_key[parseInt(x) as keyof typeof type_label_key]),
            entries: Object.values(role_dist),
            entries_number: Object.keys(role_dist).length,
            title: 'Roles',
            description: 'Distribution of Roles',
        },
        {
            labels: Object.keys(status_dist).map((x) => x.charAt(0).toUpperCase() + x.substring(1)),
            entries: Object.values(status_dist),
            entries_number: Object.keys(status_dist).length,
            title: 'Status',
            description: 'Distribution of Status',
        },
        {
            labels: ['Not Anonymous', 'Anonymous'],
            entries: [anon_dist[0], anon_dist[1]],
            entries_number: 2,
            title: 'Anonymous',
            description: 'Distribution of Anonymous',
        },
        {
            labels: Object.keys(on_behalf_dist),
            entries: Object.values(on_behalf_dist),
            entries_number: Object.keys(on_behalf_dist).length,
            title: 'On Behalf',
            description: 'Distribution of On Behalf Incidents',
        },
        {
            labels: Object.keys(on_behalf_anon_dist),
            entries: Object.values(on_behalf_anon_dist),
            entries_number: Object.keys(on_behalf_anon_dist).length,
            title: 'On Behalf Anonymous',
            description: 'Distribution of On Behalf Anonymous Incidents',
        },
        {
            labels: Object.keys(descriptor_dist),
            entries: Object.values(descriptor_dist),
            entries_number: Object.keys(descriptor_dist).length,
            title: 'Descriptor',
            description: 'Distribution of the Descriptors',
        },
        {
            labels: Object.keys(safety_dist),
            entries: Object.values(safety_dist),
            entries_number: Object.keys(safety_dist).length,
            title: 'Safety types',
            description: 'Distribution of the Safety Descriptors',
        },
        {
            labels: Object.keys(environmental_dist),
            entries: Object.values(environmental_dist),
            entries_number: Object.keys(environmental_dist).length,
            title: 'Environment types',
            description: 'Distribution of the Environment Descriptors',
        },
        {
            labels: Object.keys(security_dist),
            entries: Object.values(security_dist),
            entries_number: Object.keys(security_dist).length,
            title: 'Security types',
            description: 'Distribution of the Security Descriptors',
        },
    ];

    const data_key = ['Type', 'Witnesses', 'Roles', 'Status', 'Anonymous', 'On Behalf', 'On Behalf Anonymous'];
    const descriptor_key = ['All Descriptors', 'Safety', 'Environment', 'Security'];

    const [selected_statistics, setSelectedStatistics] = useState<number[]>([3, 1, 2, 0, 7]);

    return (
        <AuthenticatedLayout>
            <Head title='Statistics' />
            <div className="mx-8 grid grid-cols-1 gap-5 lg:grid-cols-6">
                {selected_statistics.map((indexValue, i) => (
                    <div key={i} className={classNames('relative', i < 3 ? 'lg:col-span-2' : 'lg:col-span-3')}>
                        <Graph
                            labels={data[indexValue].labels}
                            entries={data[indexValue].entries}
                            entriesNumber={data[indexValue].entries_number}
                            title={data[indexValue].title}
                            description={data[indexValue].description}
                            graphKey={i}
                            otherItems={i > 2 ? descriptor_key : data_key}
                            setNewItem={(key: number, index: number) => {
                                {
                                    if (i != 4) {
                                        setSelectedStatistics((prev) => prev.map((x, i) => (i == key ? index : x)));
                                    } else {
                                        setSelectedStatistics((prev) => prev.map((x, i) => (i == key ? index + 7 : x)));
                                    }
                                }
                            }}
                            canEdit={i != 3}
                            isBarInit={i > 2}
                        />
                    </div>
                ))}
            </div>
        </AuthenticatedLayout>
    );
}
