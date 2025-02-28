import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Incident} from "@/types/incident/Incident";
import PieGraphDisplay from "@/Pages/Report/Partials/PieGraphDisplay";
import {useEffect, useState} from "react";

export default function Stats(incidents: Incident[]) {
    // @ts-ignore
    const all_incidents: Incident[] = incidents.incidents;

    console.log(all_incidents);
    const[incidents_dataframe, setIncidents_dataframe] = useState(
        {
            closed_at: [], //Times
            created_at: [], //Times
            descriptor: [], //String
            happened_at: [], //Time
            incident_type: [], //Number
            location: [], //String
            on_behalf: [], //boolean
            on_behalf_anonymous: [], //boolean
            role: [], //number
            room_number: [], //string(in combination with location)
            status: [], //string
            supervisor_involved: [],//boolean
            updated_at: [],//date
            workers_comp_submitted: [], //boolean
            witnesses: [], //number
        }
    );
    useEffect(() => {
        for(const incident in all_incidents){
            for(const [key,value] of incident){
               // incidents_dataframe = value;
            }
        }

    }, []);
    return (
        <AuthenticatedLayout>
            {
                <div className="m-10 grid grid-cols-1 gap-5 sm:mt-10 lg:grid-cols-6 lg:grid-rows-2">
                    <div className="relative p-px lg:col-span-2">
                        <PieGraphDisplay labels={['Pig', 'Cow', 'Dog']} entries={[50,100,150]} entries_number={3} title={"Animals"} description={'How many animals'} />
                    </div>
                    <div className="relative p-px lg:col-span-2">
                        <PieGraphDisplay labels={['Pig', 'Cow', 'Dog']} entries={[50,100,150]} entries_number={3} title={"Animals"} description={'How many animals'} />
                    </div>
                    <div className="relative p-px lg:col-span-2">
                        <PieGraphDisplay labels={['Pig', 'Cow', 'Dog']} entries={[50,100,150]} entries_number={3} title={"Animals"} description={'How many animals'} />
                    </div>

                    <div className="relative p-px lg:col-span-3">
                        <PieGraphDisplay labels={['Pig', 'Cow', 'Dog']} entries={[50,100,150]} entries_number={3} title={"Animals"} description={'How many animals'} />
                    </div>
                    <div className="relative p-px lg:col-span-3">
                        <PieGraphDisplay labels={['Pig', 'Cow', 'Dog']} entries={[50,100,150]} entries_number={3} title={"Animals"} description={'How many animals'} />
                    </div>
                </div>
            }
        </AuthenticatedLayout>
    );
}
