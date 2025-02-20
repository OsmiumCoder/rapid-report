import { Incident } from '@/types/incident/Incident';
import { IncidentType } from '@/Enums/IncidentType';
import dateTimeFormat from '@/Filters/dateTimeFormat';

export default function GeneralDescription({ incident }: { incident: Incident }) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
            <dt className="font-semibold text-gray-900 text-xl">General Description</dt>
            <dd className="mt-2 text-gray-500 ml-6">
                <span className="text-gray-900">
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
                        <span className="font-semibold">Created at: </span>
                        {dateTimeFormat(incident.created_at)}
                    </div>
                    <div>
                        <span className="font-semibold">Updated at: </span>
                        {dateTimeFormat(incident.updated_at)}
                    </div>
                </span>
            </dd>
        </dl>
    );
}
