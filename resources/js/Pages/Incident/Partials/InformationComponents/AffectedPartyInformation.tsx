import { Incident } from '@/types/Incident';

export default function AffectedPartyInformation({
    incident,
}: {
    incident: Incident;
}) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
            <dt className="font-semibold text-gray-900 text-xl">
                Affected Party Information
            </dt>
            <dd className="mt-2 text-gray-500">
                <div className="text-gray-900">
                    <div>
                        <span className="font-semibold">Name: </span>
                        {incident.first_name} {incident.last_name}
                    </div>
                    <div>
                        <span className="font-semibold">UPEI ID: </span>
                        {incident.upei_id || 'N/A'}
                    </div>
                    <div>
                        <span className="font-semibold">Email: </span>
                        {incident.email}
                    </div>
                    <div>
                        <span className="font-semibold">Phone: </span>
                        {incident.phone}
                    </div>
                </div>
            </dd>
        </dl>
    );
}
