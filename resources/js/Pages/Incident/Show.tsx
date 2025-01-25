import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminActions from '@/Pages/Incident/Partials/AdminActions';
import ActivityLog from '@/Pages/Incident/Partials/ActivityLog';
import IncidentHeader from '@/Pages/Incident/Partials/IncidentHeader';
import { Head } from '@inertiajs/react';
import {PageProps} from "@/types";
import IncidentInformation from "@/Pages/Incident/Partials/IncidentInformation";

export default function Show({ incident }: PageProps<{ incident: any }>) {
    return (
        <AuthenticatedLayout>
            <Head title="Incident" />
            {/*<pre>{JSON.stringify(incident, null, 1)}</pre> /!* Remove this *!/*/}
            {/*
            delete <pre> {...} </pre>
            https://tailwindui.com/components/application-ui/page-examples/detail-screens
            then add empty tag <> ... </>
            null => N/A or Unavailable; except First-Aid and Injury
            First-Aid = No first-aid was administered.
            Injury = No injuries were sustained.

            Once page is complete, break down large items into components.
            Each component should be a file in the "Partials" dir

            AuthenticatedLayout.tsx -> Line #20 is an example

            NavigationItems.tsx has good examples for React

            Time spent:
            Jan. 18th -> 1.5 hrs
            Jan. 19th -> 1 hr
            Jan. 20th -> 1.5 hr
            Jan. 21st -> 0.5 hr
            Jan. 24th -> 1.5 hr
            in a div, to get info from incident, use {incident.attribute} -> the attribute is what you want like id, name, date, etc...
            */}
            <>
                <main>
                    {/* Incident Header */}
                    <IncidentHeader incident={incident}></IncidentHeader>

                    <div className="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            <AdminActions incident={incident}></AdminActions>

                            <IncidentInformation incident={incident}/>

                            <ActivityLog incident={incident}></ActivityLog>
                        </div>
                    </div>
                </main>
            </>
        </AuthenticatedLayout>
    );
}
