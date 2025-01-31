import { Incident } from '@/types/incident/Incident';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import PrimaryButton from '@/Components/PrimaryButton';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import { assignSupervisor } from '@/Pages/Incident/Partials/AdminActionComponents/supervisorActions';
import ConfirmationModal, {
    useConfirmationModalProps,
} from '@/Components/ConfirmationModal';

export default function StatusUpdate({ incident }: { incident: Incident }) {
    const [isLoading, setIsLoading] = useState(false);
    const [modalProps, setModalProps] = useConfirmationModalProps();

    const closeIncident = () => {
        setIsLoading(true);
        router.put(
            route('incidents.close', { incident: incident.id }),
            undefined,
            {
                onSuccess: (_) => {
                    router.reload({ only: ['incident'] });
                    setIsLoading(false);
                },
                preserveScroll: true,
            }
        );
    };

    const reopenIncident = () => {
        setIsLoading(true);
        router.put(
            route('incidents.reopen', { incident: incident.id }),
            undefined,
            {
                onSuccess: (_) => {
                    router.reload({ only: ['incident'] });
                    setIsLoading(false);
                },
                preserveScroll: true,
            }
        );
    };

    return (
        <>
            <div className="mt-6 w-full flex justify-evenly border-t border-gray-900/5 p-6">
                {isLoading ? (
                    <LoadingIndicator />
                ) : (
                    <>
                        {incident.status !== IncidentStatus.CLOSED && (
                            <PrimaryButton
                                onClick={() =>
                                    setModalProps({
                                        title: 'Close Incident',
                                        text: 'Are you sure you want to close this incident?',
                                        action: () => closeIncident(),
                                        show: true,
                                    })
                                }
                            >
                                Close Incident
                            </PrimaryButton>
                        )}
                        {incident.status === IncidentStatus.CLOSED && (
                            <PrimaryButton
                                onClick={() =>
                                    setModalProps({
                                        title: 'Reopen Incident',
                                        text: 'Are you sure you want to reopen this incident?',
                                        action: () => reopenIncident(),
                                        show: true,
                                    })
                                }
                            >
                                Reopen Incident
                            </PrimaryButton>
                        )}

                        {incident.status === IncidentStatus.IN_REVIEW && (
                            <PrimaryButton
                                onClick={() =>
                                    setModalProps({
                                        title: 'Request Re-Investigation',
                                        text: `Are you sure you want to request ${incident.supervisor?.name} to further investigate this incident? They will be reassigned and notified.`,
                                        action: () =>
                                            incident.supervisor_id &&
                                            assignSupervisor(
                                                incident.supervisor_id,
                                                incident,
                                                setIsLoading
                                            ),
                                        show: true,
                                    })
                                }
                            >
                                Request Re-Investigation
                            </PrimaryButton>
                        )}
                    </>
                )}
            </div>
            <ConfirmationModal
                title={modalProps.title}
                text={modalProps.text}
                action={modalProps.action}
                show={modalProps.show}
                setShow={modalProps.setShow}
            />
        </>
    );
}
