import { Incident } from '@/types/incident/Incident';

export const nameFilter = (incident: Incident) => {
    const firstName = incident.first_name ?? '';
    const lastName = incident.last_name ?? '';

    if (firstName.length === 0 && lastName.length === 0) {
        return ['Anonymous', 'User'];
    }

    return [firstName, lastName];
};
