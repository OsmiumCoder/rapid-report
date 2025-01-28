import { Incident } from '@/types/Incident';

export default function SupervisorInformation({
    incident,
}: {
    incident: Incident;
}) {
    return (
        <>
            {(incident.supervisor_name || incident.supervisor) && (
                <dl className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                    <dt className="font-semibold text-gray-900 text-xl">
                        Supervisor
                    </dt>
                    <dd className="mt-2">
                        {incident.supervisor && (
                            <>
                                <div>
                                    <span className="text-gray-900 font-semibold">
                                        Name:{' '}
                                    </span>
                                    {incident.supervisor.name}
                                </div>
                                <div>
                                    <span className="text-gray-900 font-semibold">
                                        Email:{' '}
                                    </span>
                                    {incident.supervisor.email}
                                </div>

                                <br />
                            </>
                        )}
                        {incident.supervisor_name && (
                            <div>
                                <span className="text-gray-900 font-semibold">
                                    Reported Supervisor Name:{' '}
                                </span>
                                {incident.supervisor_name}
                            </div>
                        )}
                    </dd>
                </dl>
            )}
        </>
    );
}
