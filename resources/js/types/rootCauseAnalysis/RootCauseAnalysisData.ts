export interface RootCauseAnalysisData {
    individuals_involved: {
        name: string;
        email: string;
        phone: string;
    }[];
    whys: string[];
    primary_effect: string;
    solutions_and_actions: {
        cause: string;
        control: string;
        remedial_action: string;
        by_who: string;
        by_when: string;
        manager: string;
    }[];
    peoples_position: string[];
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
