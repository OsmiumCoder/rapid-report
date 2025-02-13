import { Incident } from '@/types/incident/Incident';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import PrimaryButton from '@/Components/PrimaryButton';
import { Link, router } from '@inertiajs/react';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import ConfirmationModal, { useConfirmationModalProps } from '@/Components/ConfirmationModal';
import DangerButton from '@/Components/DangerButton';
import {
    closeIncident,
    reopenIncident,
    returnInvestigation,
} from '@/Helpers/Incident/statusUpdates';
import dateTimeFormat from '@/Filters/dateTimeFormat';

export default function StatusUpdate({ incident }: { incident: Incident }) {
    const [isLoading, setIsLoading] = useState(false);
    const [modalProps, setModalProps] = useConfirmationModalProps();
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
                        {incident.status === IncidentStatus.IN_REVIEW && (
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
            <ConfirmationModal modalProps={modalProps} />
        </>
    );
}
