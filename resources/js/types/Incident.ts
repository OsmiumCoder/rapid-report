import { IncidentStatus } from '@/Enums/IncidentStatus';

export interface Incident {
    id: string;
    role: number;
    last_name?: string;
    first_name?: string;
    upei_id?: string;
    email?: string;
    phone?: string;
    work_related: boolean;
    happened_at: string;
    location: string;
    room_number?: string;
    reported_to?: string;
    witnesses?: string[];
    incident_type: number;
    descriptor: string;
    description: string;
    injury_description?: string;
    first_aid_description?: string;
    reporters_email?: string;
    supervisor_name?: string;
    supervisor_id?: number;
    status: IncidentStatus;
    closed_at?: string;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
