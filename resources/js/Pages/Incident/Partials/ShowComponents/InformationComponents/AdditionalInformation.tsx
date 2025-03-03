import timeSince from '@/Formatters/timeSince';
import { uppercaseWordFormat } from '@/Formatters/uppercaseWordFormat';
import { Incident } from '@/types/incident/Incident';

export default function AdditionalInformation({ incident }: { incident: Incident }) {
    return (
        <>
            {incident.additional_information && incident.additional_information.length > 0 && (
                <div className="mt-6 border-t border-gray-900/5 pt-6 text-gray-900 sm:pr-4">
                    <dt className="text-xl font-semibold">Additional Information</dt>
                    <dd className="mt-2 ml-6">
                        <ul className="space-y-4">
                            {incident.additional_information.map(({ information, created_at }, i) => (
                                <li key={information + i}>
                                    <div className="font-medium text-gray-900">{uppercaseWordFormat(timeSince(created_at), ' ')}:</div>
                                    <div className="ml-6">{information}</div>
                                </li>
                            ))}
                        </ul>
                    </dd>
                </div>
            )}
        </>
    );
}
