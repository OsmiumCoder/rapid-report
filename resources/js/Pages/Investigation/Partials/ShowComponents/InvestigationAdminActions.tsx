import { Investigation } from '@/types/investigation/Investigation';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import { useState } from 'react';

import { closeIncident, returnInvestigation } from '@/Helpers/Incident/statusUpdates';
import LoadingIndicator from '@/Components/LoadingIndicator';
import { router } from '@inertiajs/react';
import { useConfirmationModal } from '@/Components/confirmationModal/ConfirmationModalProvider';

interface InvestigationAdminActionsProps {
    investigation: Investigation;
}
export default function InvestigationAdminActions({
    investigation,
}: InvestigationAdminActionsProps) {
    const [isLoading, setIsLoading] = useState(false);
    const { setModalProps } = useConfirmationModal();

    return (
        <>
            <div className="lg:col-start-3 lg:row-end-1 bg-white">
                <div className="rounded-lg  shadow-sm ring-1 ring-gray-900/5">
                    <div className="flex flex-wrap flex-col items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">
                            Administrative Actions
                        </div>
                        <div className="flex justify-evenly items-center w-full mt-6 border-t border-gray-900/5 p-6">
                            {isLoading ? (
                                <LoadingIndicator />
                            ) : (
                                <>
                                    <PrimaryButton
                                        onClick={() =>
                                            setModalProps({
                                                title: 'Request Re-Investigation',
                                                text: `Are you sure you want to request ${investigation.incident.supervisor?.name} to further investigate this incident? They will be notified.`,
                                                action: () =>
                                                    investigation.incident.supervisor_id &&
                                                    returnInvestigation(
                                                        investigation.incident,
                                                        setIsLoading,
                                                        () =>
                                                            router.get(
                                                                route('incidents.show', {
                                                                    incident:
                                                                        investigation.incident_id,
                                                                })
                                                            )
                                                    ),
                                                show: true,
                                            })
                                        }
                                    >
                                        Request Re-Investigation
                                    </PrimaryButton>
                                    <DangerButton
                                        onClick={() =>
                                            setModalProps({
                                                title: 'Close Incident',
                                                text: 'Are you sure you want to close the incident associated to this investigation?',
                                                action: () =>
                                                    closeIncident(
                                                        investigation.incident,
                                                        setIsLoading,
                                                        () =>
                                                            router.get(
                                                                route('incidents.show', {
                                                                    incident:
                                                                        investigation.incident_id,
                                                                })
                                                            )
                                                    ),
                                                show: true,
                                            })
                                        }
                                    >
                                        Close Incident
                                    </DangerButton>
                                </>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}
