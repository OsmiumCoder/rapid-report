import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import PieGraphDisplay from '@/Pages/Report/Partials/PieGraphDisplay';
import { JSX, useEffect, useState } from 'react';



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
    console.log(status_dist)

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
    const [selected_statistics, setSelectedStatistics] = useState<number[]>([1,1,2,3,4])
    const [display_graphs, setDisplayGraphs] = useState<JSX.Element[]>([])



    const setGraphs = () => {
       console.log(selected_statistics)
        const temp_graphs =selected_statistics.map((x,i)=> {
                return (
                    <PieGraphDisplay
                        labels={data[x].labels}
                        entries={data[x].entries}
                        entries_number={data[x].entries_number}
                        title={data[x].title}
                        description={data[x].description}
                        graph_key={i}
                        other_Items={data_key}
                        setnewItem={function (key:number, index:number) {
                            setSelectedStatistics((prev) => prev.map((x,i)=>i==key?index:x))
                            setGraphs()
                        }}
                    />
                );

            }
        )
        console.log(temp_graphs)
        setDisplayGraphs(temp_graphs)
    }
    useEffect(() => {
        setGraphs()
    });
    useEffect(() => {
        console.log(display_graphs);
    }, [display_graphs]);
    return (
        <AuthenticatedLayout>
            {
                <div className="m-10 grid grid-cols-1 gap-5 sm:mt-10 lg:grid-cols-6 lg:grid-rows-2">
                    <div className="relative p-px lg:col-span-2">
                        {display_graphs[0]}
                    </div>
                    <div className="relative p-px lg:col-span-2">
                        {display_graphs[1]}
                    </div>
                    <div className="relative p-px lg:col-span-2">
                        {display_graphs[2]}
                    </div>

                    <div className="relative p-px lg:col-span-3">
                        {display_graphs[3]}
                    </div>
                    <div className="relative p-px lg:col-span-3">
                        {display_graphs[4]}
                    </div>
                </div>
            }
        </AuthenticatedLayout>
    );
}
