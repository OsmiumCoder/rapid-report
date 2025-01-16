export interface Incident {
    id: number;
    role: number;
    last_name: string;
    first_name: string;
    upei_id: string | null;
    email: string;
    phone: string;
    work_related: boolean;
    happened_at: string;
    location: string;
    room_number: string | null;
    reported_to: string | null;
    witnesses: string[] | null;
    incident_type: number;
    descriptor: string;
    description: string;
    injury_description: string | null;
    first_aid_description: string | null;
    reporters_email: string;
    supervisor_name: string;
    supervisor_id: number;
    status: number;
    closed_at: string | null;
    created_at: string;
    updated_at: string;
    deleted_at: string | null;
}
