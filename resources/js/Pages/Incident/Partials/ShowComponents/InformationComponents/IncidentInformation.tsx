import dateFormat from '@/Formatters/dateFormat';
import { Incident } from '@/types/incident/Incident';

export default function IncidentInformation({ incident }: { incident: Incident }) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 text-gray-900 sm:pr-4">
            <dt className="text-xl font-semibold">Incident Information</dt>
            <dd className="mt-2 ml-6">
                <div>
                    <span className="font-semibold">Work Related: </span>
                    {incident.work_related ? 'Yes' : 'No'}
                </div>
                <div>
                    <span className="font-semibold">Happened At: </span>
                    {dateFormat(incident.happened_at)}
                </div>
                <div>
                    <span className="font-semibold">Location: </span>
                    {incident.location ?? 'Not Provided'}
                </div>
                <div>
                    <span className="font-semibold">Room Number: </span>
                    {incident.room_number || 'N/A'}
                </div>
            </dd>
        </dl>
    );
}
