import { Incident } from '@/types/Incident';
import dateTimeFormat from '@/Filters/dateTimeFormat';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { IncidentType } from '@/Enums/IncidentType';
import AffectedPartyInformation from '@/Pages/Incident/Partials/InformationPartials/AffectedPartyInformation';
import GeneralDescription from '@/Pages/Incident/Partials/InformationPartials/GeneralDescription';
import SupervisorInformation from '@/Pages/Incident/Partials/InformationPartials/SupervisorInformation';
import VictimInformation from '@/Pages/Incident/Partials/InformationPartials/VictimInformation';
import WitnessInformation from '@/Pages/Incident/Partials/InformationPartials/WitnessInformation';
import IncidentInformation from '@/Pages/Incident/Partials/InformationPartials/IncidentInformation';

export default function IncidentInformationCard({
    incident,
}: {
    incident: Incident;
}) {
    return (
        <div className="bg-white -mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
            <h2 className="font-semibold text-gray-900 text-2xl">Incident</h2>
            <br />
            <h3 className="font-semibold text-gray-900">
                Status:{' '}
                <span className="font-medium">
                    {uppercaseWordFormat(incident.status)}
                </span>
            </h3>

            <AffectedPartyInformation incident={incident} />
            <GeneralDescription incident={incident} />
            <IncidentInformation incident={incident} />
            <VictimInformation incident={incident} />
            <SupervisorInformation incident={incident} />
            <WitnessInformation incident={incident} />
        </div>
    );
}
