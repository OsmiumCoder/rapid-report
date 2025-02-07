import { Incident } from '@/types/incident/Incident';

export interface Investigation {
    id: string;
    incident_id: string;
    incident: Incident;
    immediate_causes: string;
    basic_causes: string;
    remedial_actions: string;
    prevention: string;
    hazard_class: string;
    risk_rank: number;
    resulted_in: string[];
}
