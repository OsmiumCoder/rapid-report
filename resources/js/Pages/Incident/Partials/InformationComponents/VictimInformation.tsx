import { Incident } from '@/types/incident/Incident';

export default function VictimInformation({
    incident,
}: {
    incident: Incident;
}) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
            <dt className="font-semibold text-gray-900 text-xl">
                Victim Information
            </dt>
            <dd className="mt-2 text-gray-500">
                <span className="text-gray-900">
                    <div>
                        <span className="font-semibold">
                            Injury Description:{' '}
                        </span>
                        {incident.injury_description ||
                            'No injuries were sustained'}
                    </div>
                    <div>
                        <span className="font-semibold">First-Aid: </span>
                        {incident.first_aid_description ||
                            'No first-aid was administered'}
                    </div>
                </span>
            </dd>
        </dl>
    );
}
