import { Incident } from '@/types/Incident';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import PrimaryButton from '@/Components/PrimaryButton';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';

export default function StatusUpdate({ incident }: { incident: Incident }) {
    const [isLoading, setIsLoading] = useState(false);

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
        <div className="mt-6  border-t border-gray-900/5 p-6">
            {isLoading ? (
                <LoadingIndicator />
            ) : incident.status === IncidentStatus.IN_REVIEW ? (
                <PrimaryButton onClick={closeIncident}>
                    Close Incident
                </PrimaryButton>
            ) : (
                incident.status === IncidentStatus.CLOSED && (
                    <PrimaryButton onClick={reopenIncident}>
                        Reopen Incident
                    </PrimaryButton>
                )
            )}
        </div>
    );
}
