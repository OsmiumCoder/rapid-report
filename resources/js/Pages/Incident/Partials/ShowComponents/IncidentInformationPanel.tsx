import Badge from '@/Components/Badge';
import { incidentBadgeColor } from '@/Formatters/incidentBadgeColor';
import { uppercaseWordFormat } from '@/Formatters/uppercaseWordFormat';
import AdditionalInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/AdditionalInformation';
import AffectedPartyInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/AffectedPartyInformation';
import GeneralDescription from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/GeneralDescription';
import IncidentInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/IncidentInformation';
import ReportingInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/ReportingInformation';
import SupervisorInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/SupervisorInformation';
import WitnessInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/WitnessInformation';
import { Incident } from '@/types/incident/Incident';

export default function IncidentInformationPanel({ incident }: { incident: Incident }) {
    return (
        <div className="-mx-4 bg-white px-4 py-8 shadow-xs ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pt-16 xl:pb-20">
            <div className="flex items-center justify-between">
                <h2 className="text-2xl font-semibold text-gray-900">Incident</h2>
                <Badge color={incidentBadgeColor(incident)} text={uppercaseWordFormat(incident.status)} />
            </div>
            <br />
            <ReportingInformation incident={incident} />
            <AffectedPartyInformation incident={incident} />
            <GeneralDescription incident={incident} />
            <IncidentInformation incident={incident} />
            <SupervisorInformation incident={incident} />
            <WitnessInformation incident={incident} />
            <AdditionalInformation incident={incident} />
        </div>
    );
}
