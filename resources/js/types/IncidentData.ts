export default interface IncidentData {
    anonymous?: boolean;
    on_behalf?: boolean;
    on_behalf_anon?: boolean;
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
    reported_to?: string;
    reporters_email?: string;
    role?: number;
    room_number?: string;
    supervisor_name?: string;
    upei_id?: string;
    witnesses?: string[];
    work_related?: boolean;
}
