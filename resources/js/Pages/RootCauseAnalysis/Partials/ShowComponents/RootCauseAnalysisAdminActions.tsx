import { useState } from 'react';
import { useConfirmationModal } from '@/Components/ConfirmationModal/ConfirmationModalProvider';
import LoadingIndicator from '@/Components/LoadingIndicator';
import PrimaryButton from '@/Components/PrimaryButton';
import { closeIncident, returnRCA } from '@/Helpers/Incident/statusUpdates';
import { router } from '@inertiajs/react';
import DangerButton from '@/Components/DangerButton';
import { RootCauseAnalysis } from '@/types/rootCauseAnalysis/RootCauseAnalysis';
import { IncidentStatus } from '@/Enums/IncidentStatus';

export default function RootCauseAnalysisAdminActions({ rca }: { rca: RootCauseAnalysis }) {
    const [isLoading, setIsLoading] = useState(false);
    const { setModalProps } = useConfirmationModal();

    console.log(rca);
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
                                    {rca.incident.status === IncidentStatus.IN_REVIEW && (
                                        <PrimaryButton
                                            onClick={() =>
                                                setModalProps({
                                                    title: 'Request New Root Cause Analysis',
                                                    text: `Are you sure you want to request ${rca.supervisor.name} to submit a new Root Cause Analysis? They will be notified.`,
                                                    action: () =>
                                                        rca.supervisor_id &&
                                                        returnRCA(rca.incident, setIsLoading, () =>
                                                            router.get(
                                                                route('incidents.show', {
                                                                    incident: rca.incident_id,
                                                                })
                                                            )
                                                        ),
                                                    show: true,
                                                })
                                            }
                                        >
                                            Re-Request RCA
                                        </PrimaryButton>
                                    )}

                                    <DangerButton
                                        onClick={() =>
                                            setModalProps({
                                                title: 'Close Incident',
                                                text: 'Are you sure you want to close the incident associated to this investigation?',
                                                action: () =>
                                                    closeIncident(rca.incident, setIsLoading, () =>
                                                        router.get(
                                                            route('incidents.show', {
                                                                incident: rca.incident_id,
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
