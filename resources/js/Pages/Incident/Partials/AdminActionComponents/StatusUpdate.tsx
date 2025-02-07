import { Incident } from '@/types/incident/Incident';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import PrimaryButton from '@/Components/PrimaryButton';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import ConfirmationModal, { useConfirmationModalProps } from '@/Components/ConfirmationModal';
import DangerButton from '@/Components/DangerButton';
import {
    closeIncident,
    reopenIncident,
    returnInvestigation,
} from '@/Helpers/Incident/statusUpdates';

export default function StatusUpdate({ incident }: { incident: Incident }) {
    const [isLoading, setIsLoading] = useState(false);
    const [modalProps, setModalProps] = useConfirmationModalProps();
    return (
        <>
            <div className="grid grid-cols-2 gap-6 w-full mt-6 border-t border-gray-900/5 p-6">
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

                        {incident.status === IncidentStatus.IN_REVIEW && (
                            <>
                                <PrimaryButton
                                    onClick={() =>
                                        router.get(
                                            route('incidents.investigations.show', {
                                                incident: incident.id,
                                                investigation: incident.investigation.id,
                                            })
                                        )
                                    }
                                >
                                    View Investigation
                                </PrimaryButton>
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
            <ConfirmationModal modalProps={modalProps} />
        </>
    );
}
