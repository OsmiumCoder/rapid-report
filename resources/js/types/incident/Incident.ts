import { IncidentStatus } from '@/Enums/IncidentStatus';
import { User } from '@/types';
import { IncidentType } from '@/Enums/IncidentType';
import { Comment } from '@/types/Comment';

export interface Incident {
    id: string;
    anonymous: boolean;
    on_behalf: boolean;
    on_behalf_anonymous: boolean;
    role: number;
    last_name?: string;
    first_name?: string;
    upei_id?: string;
    email?: string;
    phone?: string;
    work_related: boolean;
    workers_comp_submitted: boolean;
    happened_at: string;
    location?: string;
    room_number?: string;
    reported_to?: string;
    witnesses?: string[];
    incident_type: IncidentType;
    descriptor: string;
    description?: string;
    injury_description?: string;
    first_aid_description?: string;
    reporters_email?: string;
    supervisor_name?: string;
    supervisor_id?: number;
    supervisor?: User;
    status: IncidentStatus;
    comments: Comment[];
    closed_at?: string;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
