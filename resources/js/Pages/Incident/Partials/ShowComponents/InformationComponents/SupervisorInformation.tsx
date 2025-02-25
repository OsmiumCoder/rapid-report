import { Incident } from '@/types/incident/Incident';

export default function SupervisorInformation({ incident }: { incident: Incident }) {
    return (
        <>
            {(incident.supervisor_name || incident.supervisor) && (
                <dl className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                    <dt className="text-xl font-semibold text-gray-900">Supervisor</dt>
                    <dd className="mt-2 ml-6">
                        {incident.supervisor && (
                            <>
                                <div>
                                    <span className="font-semibold text-gray-900">Name: </span>
                                    {incident.supervisor.name}
                                </div>
                                <div>
                                    <span className="font-semibold text-gray-900">Email: </span>
                                    {incident.supervisor.email}
                                </div>

                                <br />
                            </>
                        )}
                        {incident.supervisor_name && (
                            <div>
                                <span className="font-semibold text-gray-900">Reported Supervisor Name: </span>
                                {incident.supervisor_name}
                            </div>
                        )}
                    </dd>
                </dl>
            )}
        </>
    );
}
