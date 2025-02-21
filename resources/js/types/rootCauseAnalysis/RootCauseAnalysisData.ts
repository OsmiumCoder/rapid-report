import { SolutionAndAction } from '@/types/rootCauseAnalysis/SolutionAndAction';
import { IndividualInvolved } from '@/types/rootCauseAnalysis/IndividualInvolved';

export interface RootCauseAnalysisData {
    individuals_involved: IndividualInvolved[];
    whys: string[];
    primary_effect: string;
    solutions_and_actions: SolutionAndAction[];
    peoples_positions: string[];
    attention_to_work: string[];
    communication: string[];
    ppe_in_good_condition: boolean | null;
    ppe_in_use: boolean | null;
    ppe_correct_type: boolean | null;
    correct_tool_used: boolean | null;
    policies_followed: boolean | null;
    worked_safely: boolean | null;
    used_tool_properly: boolean | null;
    tool_in_good_condition: boolean | null;
    working_conditions: string[];
    root_causes: string[];
}
