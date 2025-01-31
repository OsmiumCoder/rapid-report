import { Dispatch, SetStateAction } from 'react';
import { router } from '@inertiajs/react';
import { Incident } from '@/types/incident/Incident';

export const assignSupervisor = (
    supervisorId: number,
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>
) => {
    setIsLoading(true);
    router.put(
        route('incidents.assign-supervisor', { incident: incident.id }),
        { supervisor_id: supervisorId },
        {
            onSuccess: (_) => {
                router.reload({ only: ['incident'] });
                setIsLoading(false);
            },
            preserveScroll: true,
        }
    );
};

export const unassignSupervisor = (
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>
) => {
    setIsLoading(true);
    router.put(
        route('incidents.unassign-supervisor', { incident: incident.id }),
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
