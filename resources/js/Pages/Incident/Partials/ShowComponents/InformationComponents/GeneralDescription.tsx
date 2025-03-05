import { IncidentType } from '@/Enums/IncidentType';
import { Incident } from '@/types/incident/Incident';

export default function GeneralDescription({ incident }: { incident: Incident }) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 text-gray-900 sm:pr-4">
            <dt className="text-xl font-semibold">General Description</dt>
            <dd className="mt-2 ml-6">
                <div>
                    <span className="font-semibold">Type: </span>
                    {incident.incident_type === IncidentType.ENVIRONMENTAL
                        ? 'Environmental'
                        : incident.incident_type === IncidentType.SAFETY
                          ? 'Safety'
                          : incident.incident_type === IncidentType.SECURITY
                            ? 'Security'
                            : 'Unknown'}
                </div>
                <div>
                    <span className="font-semibold">Descriptor: </span>
                    {incident.descriptor}
                </div>
                <div>
                    <span className="font-semibold">Description: </span>
                    {incident.description ?? 'None Provided'}
                </div>
                <div>
                    <span className="font-semibold">Injury Description: </span>
                    {incident.injury_description || 'No injuries were sustained'}
                </div>
                <div>
                    <span className="font-semibold">First-Aid: </span>
                    {incident.first_aid_description || 'No first-aid was administered'}
                </div>
            </dd>
        </dl>
    );
}
