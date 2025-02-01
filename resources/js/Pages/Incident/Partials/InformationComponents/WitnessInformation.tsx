import { Incident } from '@/types/incident/Incident';

export default function WitnessInformation({ incident }: { incident: Incident }) {
    return (
        <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
            <dt className="font-semibold text-gray-900 text-xl">Witnesses</dt>
            <dd className="mt-2 text-gray-500">
                {incident.witnesses && incident.witnesses.length > 0 ? (
                    <ul className="list-none text-gray-900">
                        {incident.witnesses.map((witness, index) => (
                            <li key={index} className="flex flex-col gap-y-0 mb-4">
                                <div className="flex items-center gap-x-1">
                                    <span className="font-semibold">Name:</span> {witness.name}
                                </div>
                                <div className="flex items-center gap-x-1">
                                    <span className="font-semibold">Email:</span>
                                    {witness.email ? witness.email : 'None provided'}
                                </div>
                                <div className="flex items-center gap-x-1">
                                    <span className="font-semibold">Phone:</span>
                                    {witness.phone ? witness.phone : 'None provided'}
                                </div>
                            </li>
                        ))}
                    </ul>
                ) : (
                    <p>No witnesses provided</p>
                )}
            </dd>
        </div>
    );
}
