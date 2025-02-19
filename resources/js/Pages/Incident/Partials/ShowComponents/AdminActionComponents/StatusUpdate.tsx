import { Incident } from '@/types/incident/Incident';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import PrimaryButton from '@/Components/PrimaryButton';
import { Link, router } from '@inertiajs/react';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';

import DangerButton from '@/Components/DangerButton';
import {
    closeIncident,
    reopenIncident,
    returnInvestigation,
    returnRCA,
} from '@/Helpers/Incident/statusUpdates';
import dateTimeFormat from '@/Filters/dateTimeFormat';
import { useConfirmationModal } from '@/Components/ConfirmationModal/ConfirmationModalProvider';

export default function StatusUpdate({ incident }: { incident: Incident }) {
    const [isLoading, setIsLoading] = useState(false);
    const { setModalProps } = useConfirmationModal();
    return (
        <>
            <div className="flex flex-col gap-y-6 w-full mt-6 border-t border-gray-900/5 p-6">
                {isLoading ? (
                    <LoadingIndicator />
                ) : (
                    <>
                        {incident.status === IncidentStatus.CLOSED && (
                            <PrimaryButton
                                className="col-span-2"
                                onClick={() =>
                                    setModalProps({
                                        title: 'Reopen Incident',
                                        text: 'Are you sure you want to reopen this incident?',
                                        action: () =>
                                            reopenIncident(incident, setIsLoading, () =>
                                                router.reload({ only: ['incident'] })
                                            ),
                                        show: true,
                                    })
                                }
                            >
                                Reopen Incident
                            </PrimaryButton>
                        )}

                        {incident.investigations.length > 0 && (
                            <>
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
                            </>
                        )}
                        {incident.root_cause_analyses.length > 0 && (
                            <>
                                <div className="font-semibold">
                                    Root Cause Analyses
                                    {incident.root_cause_analyses.map((rca, index) => (
                                        <div className="font-normal">
                                            <Link
                                                className="text-sm cursor-pointer text-blue-500 hover:text-blue-400"
                                                href={route('incidents.root-cause-analyses.show', {
                                                    incident: rca.incident_id,
                                                    root_cause_analysis: rca.id,
                                                })}
                                            >
                                                {rca.supervisor.name}:{' '}
                                                {dateTimeFormat(rca.created_at)}
                                            </Link>
                                        </div>
                                    ))}
                                </div>
                            </>
                        )}
                        {incident.status === IncidentStatus.IN_REVIEW && incident.supervisor && (
                            <>
                                <PrimaryButton
                                    onClick={() =>
                                        setModalProps({
                                            title: 'Request Re-Investigation',
                                            text: `Are you sure you want to request ${incident.supervisor?.name} to further investigate this incident? They will be notified.`,
                                            action: () =>
                                                incident.supervisor_id &&
                                                returnInvestigation(incident, setIsLoading, () =>
                                                    router.reload({ only: ['incident'] })
                                                ),
                                            show: true,
                                        })
                                    }
                                >
                                    Request Re-Investigation
                                </PrimaryButton>
                                <PrimaryButton
                                    onClick={() =>
                                        setModalProps({
                                            title: 'Request New Root Cause Analysis',
                                            text: `Are you sure you want to request ${incident.supervisor?.name} to submit a new Root Cause Analysis? They will be notified.`,
                                            action: () =>
                                                incident.supervisor_id &&
                                                returnRCA(incident, setIsLoading, () =>
                                                    router.get(
                                                        route('incidents.show', {
                                                            incident: incident.id,
                                                        })
                                                    )
                                                ),
                                            show: true,
                                        })
                                    }
                                >
                                    Re-Request RCA
                                </PrimaryButton>
                            </>
                        )}
                        {incident.status !== IncidentStatus.CLOSED && (
                            <DangerButton
                                className="col-span-2"
                                onClick={() =>
                                    setModalProps({
                                        title: 'Close Incident',
                                        text: 'Are you sure you want to close this incident?',
                                        action: () =>
                                            closeIncident(incident, setIsLoading, () =>
                                                router.reload({ only: ['incident'] })
                                            ),
                                        show: true,
                                    })
                                }
                            >
                                Close Incident
                            </DangerButton>
                        )}
                    </>
                )}
            </div>
        </>
    );
}
