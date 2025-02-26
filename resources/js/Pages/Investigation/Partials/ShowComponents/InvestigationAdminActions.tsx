import DangerButton from '@/Components/DangerButton';
import PrimaryButton from '@/Components/PrimaryButton';
import { Investigation } from '@/types/investigation/Investigation';
import { useState } from 'react';

import { useConfirmationModal } from '@/Components/ConfirmationModal/ConfirmationModalProvider';
import LoadingIndicator from '@/Components/LoadingIndicator';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import { closeIncident, returnInvestigation } from '@/Helpers/Incident/statusUpdates';
import { router } from '@inertiajs/react';

interface InvestigationAdminActionsProps {
    investigation: Investigation;
}
export default function InvestigationAdminActions({ investigation }: InvestigationAdminActionsProps) {
    const [isLoading, setIsLoading] = useState(false);
    const { setModalProps } = useConfirmationModal();

    return (
        <>
            <div className="bg-white lg:col-start-3 lg:row-end-1">
                <div className="rounded-lg shadow-xs ring-1 ring-gray-900/5">
                    <div className="flex flex-col flex-wrap items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">Administrative Actions</div>
                        <div className="mt-6 flex w-full items-center justify-evenly border-t border-gray-900/5 p-6">
                            {isLoading ? (
                                <LoadingIndicator />
                            ) : (
                                <>
                                    {investigation.incident.status === IncidentStatus.IN_REVIEW && (
                                        <PrimaryButton
                                            onClick={() =>
                                                setModalProps({
                                                    title: 'Request Re-Investigation',
                                                    text: `Are you sure you want to request ${investigation.supervisor.name} to further investigate this incident? They will be notified.`,
                                                    action: () =>
                                                        investigation.incident.supervisor_id &&
                                                        returnInvestigation(investigation.incident, setIsLoading, () =>
                                                            router.get(
                                                                route('incidents.show', {
                                                                    incident: investigation.incident.slug,
                                                                }),
                                                            ),
                                                        ),
                                                    show: true,
                                                })
                                            }
                                        >
                                            Request Re-Investigation
                                        </PrimaryButton>
                                    )}

                                    <DangerButton
                                        onClick={() =>
                                            setModalProps({
                                                title: 'Close Incident',
                                                text: 'Are you sure you want to close the incident associated to this investigation?',
                                                action: () =>
                                                    closeIncident(investigation.incident, setIsLoading, () =>
                                                        router.get(
                                                            route('incidents.show', {
                                                                incident: investigation.incident.slug,
                                                            }),
                                                        ),
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
