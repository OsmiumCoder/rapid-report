import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Incident} from "@/types/incident/Incident";
import PieGraphDisplay from "@/Pages/Report/Partials/PieGraphDisplay";
import {useEffect} from "react";

interface data_frame{
    closed_at : string[], //Times
    created_at: string[], //Times
    descriptor: string[], //String
    happened_at: string[], //Time
    incident_type: number[], //Number
    location: string[], //String
    on_behalf: boolean[], //boolean
    on_behalf_anonymous: boolean[], //boolean
    role: number[], //number
    room_number: string[], //string(in combination with location)
    status: string[], //string
    supervisor_involved: boolean[], //boolean
    updated_at: string[], //date
    workers_comp_submitted: boolean[], //boolean
    witnesses: number[], //number
}
export default function Stats(incidents: { incidents: Incident[] }) {
    const all_incidents: Incident[] = incidents.incidents;
    console.log(all_incidents);
    const incidents_dataframe :data_frame = {
        closed_at : [], //Times
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
        supervisor_involved: [], //boolean
        updated_at: [], //date
        workers_comp_submitted: [], //boolean
        witnesses: [], //number
    };

    useEffect(() => {
        for(const incident of all_incidents){
            incidents_dataframe.closed_at.push(incident.closed_at ? incident.closed_at: 'null');
            incidents_dataframe.created_at.push(incident.created_at ? incident.created_at: 'null');
            incidents_dataframe.descriptor.push(incident.descriptor ? incident.descriptor: 'null');
            incidents_dataframe.happened_at.push(incident.happened_at ? incident.happened_at: 'null');
            incidents_dataframe.incident_type.push(incident.incident_type ? incident.incident_type: -1);
            incidents_dataframe.location.push(incident.location ? incident.location: 'null');
            incidents_dataframe.on_behalf.push(incident.on_behalf ? incident.on_behalf: false);
            incidents_dataframe.on_behalf_anonymous.push(incident.on_behalf_anonymous ? incident.on_behalf_anonymous: false);
            incidents_dataframe.role.push(incident.role ? incident.role: -1);
            incidents_dataframe.room_number.push(incident.room_number ? incident.room_number: 'null');
            incidents_dataframe.status.push(incident.status ? incident.status: 'null');
            incidents_dataframe.supervisor_involved.push(!!incident.supervisor);
            incidents_dataframe.updated_at.push(incident.updated_at ? incident.updated_at: 'null');
            incidents_dataframe.workers_comp_submitted.push(incident.workers_comp_submitted ? incident.workers_comp_submitted: false);
            incidents_dataframe.witnesses.push(incident.witnesses ? incident.witnesses.length: 0);
        }

        check();
        })

    const check = () => {
        console.log(incidents_dataframe);}
    return (
        <AuthenticatedLayout>
            {
                <div className="m-10 grid grid-cols-1 gap-5 sm:mt-10 lg:grid-cols-6 lg:grid-rows-2">
                    <div className="relative p-px lg:col-span-2">
                        <PieGraphDisplay
                            labels={['Pig', 'Cow', 'Dog']}
                            entries={[50, 100, 150]}
                            entries_number={3}
                            title={'Animals'}
                            description={'How many animals'}

                        />
                    </div>
                    <div className="relative p-px lg:col-span-2">
                        <PieGraphDisplay
                            labels={['Pig', 'Cow', 'Dog']}
                            entries={[50, 100, 150]}
                            entries_number={3}
                            title={'Animals'}
                            description={'How many animals'}
                        />
                    </div>
                    <div className="relative p-px lg:col-span-2">
                        <PieGraphDisplay
                            labels={['Pig', 'Cow', 'Dog']}
                            entries={[50, 100, 150]}
                            entries_number={3}
                            title={'Animals'}
                            description={'How many animals'}
                        />
                    </div>

                    <div className="relative p-px lg:col-span-3">
                        <PieGraphDisplay
                            labels={['Pig', 'Cow', 'Dog']}
                            entries={[50, 100, 150]}
                            entries_number={3}
                            title={'Animals'}
                            description={'How many animals'}
                        />
                    </div>
                    <div className="relative p-px lg:col-span-3">
                        <PieGraphDisplay
                            labels={['Pig', 'Cow', 'Dog']}
                            entries={[50, 100, 150]}
                            entries_number={3}
                            title={'Animals'}
                            description={'How many animals'}
                        />
                    </div>
                </div>
            }
        </AuthenticatedLayout>
    );
}
