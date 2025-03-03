import { Incident } from '@/types/incident/Incident';

export default function VictimInformation({ incident }: { incident: Incident }) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 text-gray-900 sm:pr-4">
            <dt className="text-xl font-semibold">Incident Information</dt>
            <dd className="mt-2 ml-6">
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
