import AffectedPartyInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/AffectedPartyInformation';
import GeneralDescription from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/GeneralDescription';
import IncidentInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/IncidentInformation';
import VictimInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/VictimInformation';
import SupervisorInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/SupervisorInformation';
import WitnessInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/WitnessInformation';
import { Incident } from '@/types/incident/Incident';
import Badge from '@/Components/Badge';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';

export default function ReviewStage({ incidentData }: { incidentData: Incident }) {
    return (
        <div className="flex flex-col w-full mx-5">
            <div className="flex flex-col items-center mt-5">
                <h2 className="font-semibold text-gray-900 text-2xl">Information Review</h2>
                <div>Please review your submitted information before submitting.</div>
            </div>
            <AffectedPartyInformation incident={incidentData} />
            <GeneralDescription incident={incidentData} />
            <IncidentInformation incident={incidentData} />
            <VictimInformation incident={incidentData} />
            <SupervisorInformation incident={incidentData} />
            <WitnessInformation incident={incidentData} />
        </div>
    );
}
