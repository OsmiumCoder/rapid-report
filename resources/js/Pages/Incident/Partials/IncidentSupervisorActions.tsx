import { IncidentStatus } from '@/Enums/IncidentStatus';

import { Incident } from '@/types/incident/Incident';

import { Link, router } from '@inertiajs/react';
import dateTimeFormat from '@/Filters/dateTimeFormat';

interface SupervisorActionsProps {
    incident: Incident;
}

export default function IncidentSupervisorActions({ incident }: SupervisorActionsProps) {
    return (
        <div className="lg:col-start-3 lg:row-end-1 bg-white">
            <div className="rounded-lg  shadow-sm ring-1 ring-gray-900/5">
                <div className="flex flex-wrap flex-col items-center justify-between">
                    <div className="mt-1 pt-6 text-base font-semibold text-gray-900">
                        Supervisor Actions
                    </div>
                    {incident.investigations.length > 0 && (
                        <div className="flex flex-col gap-y-6 w-full mt-6 border-t border-gray-900/5 p-6">
                            <div className="font-semibold">
                                Investigations
                                {incident.investigations.map((investigation, index) => (
                                    <div className="font-normal">
                                        <Link
                                            className="text-sm cursor-pointer text-blue-500 hover:text-blue-400"
                                            href={route('incidents.investigations.show', {
                                                incident: incident.id,
                                                investigation: investigation.id,
                                            })}
                                        >
                                            {investigation.supervisor.name}:{' '}
                                            {dateTimeFormat(investigation.created_at)}
                                        </Link>
                                    </div>
                                ))}
                            </div>
                        </div>
                    )}

                    {incident.status === IncidentStatus.ASSIGNED && (
                        <div className="flex flex-col gap-y-6 w-full mt-6 border-t border-gray-900/5 p-6">
                            <Link
                                href={route('incidents.investigations.create', {
                                    incident: incident.id,
                                })}
                                as="button"
                                className="text-center rounded-md bg-upei-green-500 px-3 py-2  text-sm font-semibold text-white shadow-sm hover:bg-upei-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600"
                            >
                                Submit Investigation
                            </Link>
                            <Link
                                href={route('incidents.root-cause-analyses.create', {
                                    incident: incident.id,
                                })}
                                as="button"
                                className="text-center rounded-md bg-upei-green-500 px-3 py-2  text-sm font-semibold text-white shadow-sm hover:bg-upei-green-400 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600"
                            >
                                Submit Root Cause Analysis
                            </Link>
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}
