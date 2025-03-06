import AffectedPartyInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/AffectedPartyInformation';
import GeneralDescription from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/GeneralDescription';
import IncidentInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/IncidentInformation';
import SupervisorInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/SupervisorInformation';
import WitnessInformation from '@/Pages/Incident/Partials/ShowComponents/InformationComponents/WitnessInformation';
import { Incident } from '@/types/incident/Incident';

export default function ReviewStage({ incidentData }: { incidentData: Incident }) {
    return (
        <div className="mx-5 flex w-full flex-col">
            <div className="mt-5 flex flex-col items-center">
                <h2 className="text-2xl font-semibold text-gray-900">Information Review</h2>
                <div>Please review your submitted information before submitting.</div>
            </div>
            <AffectedPartyInformation incident={incidentData} />
            <GeneralDescription incident={incidentData} />
            <IncidentInformation incident={incidentData} />
            <SupervisorInformation incident={incidentData} />
            <WitnessInformation incident={incidentData} />
        </div>
    );
}
