import { Witness } from '@/types/incident/Witness';

export default interface IncidentData {
    anonymous?: boolean;
    on_behalf?: boolean;
    on_behalf_anonymous?: boolean;
    description?: string;
    descriptor?: string;
    other_descriptor?: string;
    email?: string;
    first_aid_description?: string;
    first_name?: string;
    last_name?: string;
    happened_at?: string;
    incident_type?: number;
    injury_description?: string;
    location?: string;
    phone?: string;
    reporters_email?: string;
    role?: number;
    room_number?: string;
    supervisor_name?: string;
    upei_id?: string;
    witnesses: Witness[];
    work_related?: boolean;
    has_injury?: boolean;
    workers_comp_submitted?: boolean;
    first_aid_applied?: boolean;
}
