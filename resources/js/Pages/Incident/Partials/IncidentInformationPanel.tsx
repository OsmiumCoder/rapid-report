import { Incident } from '@/types/incident/Incident';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import AffectedPartyInformation from '@/Pages/Incident/Partials/InformationComponents/AffectedPartyInformation';
import GeneralDescription from '@/Pages/Incident/Partials/InformationComponents/GeneralDescription';
import SupervisorInformation from '@/Pages/Incident/Partials/InformationComponents/SupervisorInformation';
import VictimInformation from '@/Pages/Incident/Partials/InformationComponents/VictimInformation';
import WitnessInformation from '@/Pages/Incident/Partials/InformationComponents/WitnessInformation';
import IncidentInformation from '@/Pages/Incident/Partials/InformationComponents/IncidentInformation';
import Badge, { BadgeColor } from '@/Components/Badge';
import { IncidentStatus } from '@/Enums/IncidentStatus';

export default function IncidentInformationPanel({
    incident,
}: {
    incident: Incident;
}) {
    const getBadgeColor: () => BadgeColor = () =>
        incident.status === IncidentStatus.OPENED
            ? 'blue'
            : incident.status === IncidentStatus.ASSIGNED
              ? 'yellow'
              : incident.status === IncidentStatus.IN_REVIEW
                ? 'purple'
                : incident.status === IncidentStatus.CLOSED
                  ? 'green'
                  : 'red';

    return (
        <div className="bg-white -mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
            <div className="flex items-center justify-between">
                <h2 className="font-semibold text-gray-900 text-2xl">
                    Incident
                </h2>
                <Badge
                    color={getBadgeColor()}
                    text={uppercaseWordFormat(incident.status)}
                />
            </div>
            <br />

            <AffectedPartyInformation incident={incident} />
            <GeneralDescription incident={incident} />
            <IncidentInformation incident={incident} />
            <VictimInformation incident={incident} />
            <SupervisorInformation incident={incident} />
            <WitnessInformation incident={incident} />
        </div>
    );
}
