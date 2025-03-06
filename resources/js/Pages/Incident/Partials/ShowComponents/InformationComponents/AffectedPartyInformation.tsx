import { nameFormat } from '@/Formatters/nameFormat';
import { Incident } from '@/types/incident/Incident';

export default function AffectedPartyInformation({ incident }: { incident: Incident }) {
    const [firstName, lastName] = nameFormat(incident);

    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 text-gray-900 sm:pr-4">
            <dt className="text-xl font-semibold">Affected Party Information</dt>
            <dd className="mt-2 ml-6">
                <div>
                    <span className="font-semibold">Name: </span>
                    {firstName} {lastName}
                </div>
                <div>
                    <span className="font-semibold">UPEI ID: </span>
                    {incident.upei_id ?? 'N/A'}
                </div>
                <div>
                    <span className="font-semibold">Email: </span>
                    {incident.email ?? 'Not Provided'}
                </div>
                <div>
                    <span className="font-semibold">Phone: </span>
                    {incident.phone ?? 'Not Provided'}
                </div>
            </dd>
        </dl>
    );
}
