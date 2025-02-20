import { router } from '@inertiajs/react';
import { Dispatch, SetStateAction } from 'react';
import { Incident } from '@/types/incident/Incident';

export const returnInvestigation = (
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void
) => {
    setIsLoading(true);
    router.patch(route('incidents.return-investigation', { incident: incident.id }), undefined, {
        onSuccess: (_) => onSuccess(),
        onFinish: (_) => setIsLoading(false),
        preserveScroll: true,
    });
};

export const returnRCA = (
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void
) => {
    setIsLoading(true);
    router.patch(route('incidents.return-rca', { incident: incident.id }), undefined, {
        onSuccess: (_) => onSuccess(),
        onFinish: (_) => setIsLoading(false),
        preserveScroll: true,
    });
};

export const closeIncident = (
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void
) => {
    setIsLoading(true);
    router.patch(route('incidents.close', { incident: incident.id }), undefined, {
        onSuccess: (_) => onSuccess(),
        onFinish: (_) => setIsLoading(false),
        preserveScroll: true,
    });
};

export const reopenIncident = (
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void
) => {
    setIsLoading(true);
    router.patch(route('incidents.reopen', { incident: incident.id }), undefined, {
        onSuccess: (_) => onSuccess(),
        onFinish: (_) => setIsLoading(false),
        preserveScroll: true,
    });
};

export const assignSupervisor = (
    supervisorId: number,
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void
) => {
    setIsLoading(true);
    router.patch(
        route('incidents.assign-supervisor', { incident: incident.id }),
        { supervisor_id: supervisorId },
        {
            onSuccess: (_) => onSuccess(),
            onFinish: (_) => setIsLoading(false),
            preserveScroll: true,
        }
    );
};

export const unassignSupervisor = (
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void
) => {
    setIsLoading(true);
    router.patch(route('incidents.unassign-supervisor', { incident: incident.id }), undefined, {
        onSuccess: (_) => onSuccess(),
        onFinish: (_) => setIsLoading(false),
        preserveScroll: true,
    });
};
