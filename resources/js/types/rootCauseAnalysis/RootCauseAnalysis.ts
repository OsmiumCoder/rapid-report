import { User } from '@/types';
import { Incident } from '@/types/incident/Incident';
import { IndividualInvolved } from '@/types/rootCauseAnalysis/IndividualInvolved';
import { SolutionAndAction } from '@/types/rootCauseAnalysis/SolutionAndAction';

export interface RootCauseAnalysis {
    id: string;
    supervisor_id: string;
    supervisor: User;
    incident_id: string;
    incident: Incident;
    individuals_involved: IndividualInvolved[];
    primary_effect: string;
    whys: string[];
    solutions_and_actions: SolutionAndAction[];
    peoples_positions: string[];
    attention_to_work: string[];
    communication: string[];
    ppe_in_good_condition: boolean;
    ppe_in_use: boolean;
    ppe_correct_type: boolean;
    correct_tool_used: boolean;
    policies_followed: boolean;
    worked_safely: boolean;
    used_tool_properly: boolean;
    tool_in_good_condition: boolean;
    working_conditions: string[];
    root_causes: string[];
    created_at: string;
    updated_at: string;
}
