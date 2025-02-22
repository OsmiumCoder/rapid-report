import { Incident } from '@/types/incident/Incident';
import timeSince from '@/Filters/timeSince';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';

export default function AdditionalInformation({ incident }: { incident: Incident }) {
    return (
        <>
            {incident.additional_information && incident.additional_information.length > 0 && (
                <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                    <dt className="font-semibold text-gray-900 text-xl">Additional Information</dt>
                    <dd className="mt-2 text-gray-500 ml-6">
                        <ul className="text-gray-900 space-y-4">
                            {incident.additional_information.map(
                                ({ information, created_at }, i) => (
                                    <li key={information + i}>
                                        <div className="font-medium text-gray-900">
                                            {uppercaseWordFormat(timeSince(created_at), ' ')}:
                                        </div>
                                        <div className="ml-6">{information}</div>
                                    </li>
                                )
                            )}
                        </ul>
                    </dd>
                </div>
            )}
        </>
    );
}
