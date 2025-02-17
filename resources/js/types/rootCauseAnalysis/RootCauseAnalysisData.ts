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
}
