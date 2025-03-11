import { Incident } from '@/types/incident/Incident';
import { router } from '@inertiajs/react';
import { Dispatch, SetStateAction } from 'react';

export const returnInvestigation = (incident: Incident, setIsLoading: Dispatch<SetStateAction<boolean>>, onSuccess: () => void) => {
    setIsLoading(true);
    router.patch(route('incidents.return-investigation', { incident: incident.slug }), undefined, {
        onSuccess: onSuccess,
        onFinish: () => setIsLoading(false),
        preserveScroll: true,
    });
};

export const returnRCA = (incident: Incident, setIsLoading: Dispatch<SetStateAction<boolean>>, onSuccess: () => void) => {
    setIsLoading(true);
    router.patch(route('incidents.return-rca', { incident: incident.slug }), undefined, {
        onSuccess: onSuccess,
        onFinish: () => setIsLoading(false),
        preserveScroll: true,
    });
};

export const closeIncident = (incident: Incident, setIsLoading: Dispatch<SetStateAction<boolean>>, onSuccess: () => void) => {
    setIsLoading(true);
    router.patch(route('incidents.close', { incident: incident.slug }), undefined, {
        onSuccess: onSuccess,
        onFinish: () => setIsLoading(false),
        preserveScroll: true,
    });
};

export const reopenIncident = (incident: Incident, setIsLoading: Dispatch<SetStateAction<boolean>>, onSuccess: () => void) => {
    setIsLoading(true);
    router.patch(route('incidents.reopen', { incident: incident.slug }), undefined, {
        onSuccess: onSuccess,
        onFinish: () => setIsLoading(false),
        preserveScroll: true,
    });
};

export const assignSupervisor = (
    supervisorId: number,
    incident: Incident,
    setIsLoading: Dispatch<SetStateAction<boolean>>,
    onSuccess: () => void,
) => {
    setIsLoading(true);
    router.patch(
        route('incidents.assign-supervisor', { incident: incident.slug }),
        { supervisor_id: supervisorId },
        {
            onSuccess: onSuccess,
            onFinish: () => setIsLoading(false),
            preserveScroll: true,
        },
    );
};

export const unassignSupervisor = (incident: Incident, setIsLoading: Dispatch<SetStateAction<boolean>>, onSuccess: () => void) => {
    setIsLoading(true);
    router.patch(route('incidents.unassign-supervisor', { incident: incident.slug }), undefined, {
        onSuccess: onSuccess,
        onFinish: () => setIsLoading(false),
        preserveScroll: true,
    });
};
