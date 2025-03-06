import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PieGraphDisplay from '@/Pages/Report/Partials/PieGraphDisplay';
import {useState } from 'react';
import classNames from '@/Formatters/classNames';



interface dataEntry{
    labels: string[],
    entries: number[],
    entries_number: number,
    title: string,
    description: string,
}
export default function Stats({type_dist, witnesses_dist, role_dist,status_dist,anon_dist}:
{   type_dist:number[],
    witnesses_dist:number[],
    role_dist:number[],
    status_dist:number[],
    anon_dist:number[],
} ) {
    const type_label_key = {
        1:'Safety',
        2: 'Environmental',
        3: 'Security',
    }

    const role_label_key = {
        1: 'Employee',
        2: 'Student',
        3: 'Visitor',
        4: 'Contractor'
    }

    const data:dataEntry[] = [
        {
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-expect-error
            labels: Object.keys(type_dist).map((x)=> type_label_key[+x]),
            entries: Object.values(type_dist),
            entries_number: type_dist.length,
            title: 'Incident Type',
            description: 'Type of Incident Distribution',
        },
        {
            labels:Object.keys(witnesses_dist),
            entries:Object.values(witnesses_dist),
            entries_number:Object.keys(witnesses_dist).length,
            title:'Witness Counts',
            description:'Most Common Witnesses'
        },
        {
            // eslint-disable-next-line @typescript-eslint/ban-ts-comment
            // @ts-expect-error
            labels:Object.keys(role_dist).map((x)=> role_label_key[+x]),
            entries:Object.values(role_dist),
            entries_number:Object.keys(role_dist).length,
            title:'Roles',
            description:'Distribution of Roles'
        },
        {

            labels:Object.keys(status_dist).map((x)=> x.charAt(0).toUpperCase()+x.substring(1)),
            entries:Object.values(status_dist),
            entries_number:Object.keys(status_dist).length,
            title:'Status',
            description:'Distribution of Status'
        },
        {
            labels:['Not Anonymous','Anonymous'],
            entries:[anon_dist[0],anon_dist[1]],
            entries_number:2,
            title:'Anonymous',
            description:'Distribution of Anonymous'
        }

    ]

    const data_key = ['Type', 'Witnesses', 'Roles', 'Status', "Anonymous"]

    const [selected_statistics, setSelectedStatistics] = useState<number[]>([0,1,2,3,4])

    return (
        <AuthenticatedLayout>
                <div className="mx-8 grid grid-cols-1 gap-5 lg:grid-cols-6">
                    {selected_statistics.map((indexValue,i)=>
                                <div key={i} className={classNames("relative", i<3 ? 'lg:col-span-2' : 'lg:col-span-3')}>
                                <PieGraphDisplay
                                    labels={data[indexValue].labels}
                                    entries={data[indexValue].entries}
                                    entries_number={data[indexValue].entries_number}
                                    title={data[indexValue].title}
                                    description={data[indexValue].description}
                                    graph_key={i}
                                    other_Items={data_key}
                                    setnewItem={(key:number, index:number)=>{
                                        setSelectedStatistics((prev) => prev.map((x, i) => (i == key ? index : x)));
                                    }}
                                />
                                </div>
                    )}
                </div>
        </AuthenticatedLayout>
    );
}
