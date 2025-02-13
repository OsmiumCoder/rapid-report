import { Incident } from '@/types/incident/Incident';
import {User} from "@/types";

export interface Investigation {
    id: string;
    supervisor_id: number;
    incident_id: string;
    incident: Incident;
    immediate_causes: string;
    basic_causes: string;
    remedial_actions: string;
    prevention: string;
    hazard_class: string;
    risk_rank: number;
    resulted_in: string[];
    substandard_acts: string[];
    substandard_conditions: string[];
    energy_transfer_causes: string[];
    personal_factors: string[];
    job_factors: string[];
    created_at: string;
    updated_at: string;
    deleted_at?: string;
    supervisor: User;
}
