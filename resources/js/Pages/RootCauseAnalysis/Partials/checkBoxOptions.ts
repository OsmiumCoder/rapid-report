import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';

export const peoplesPositionsValues = [
    'Alignment',
    'Line of fire',
    'Overreaching',
    'Over exertion',
    'Repetition',
];

export const attentionToWorkValues = [
    'Awareness of surroundings',
    'Eyes on task',
    'Mind on task',
    'Pace',
    'Work plan design',
];

export const communicationValues = [
    'JHA',
    'Plan',
    'Recognize change',
    'Task coordination',
    'Tools/equipment put away',
];

export const workingConditions = [
    'Ambient conditions',
    'Clean/clear of clutter',
    'Footing',
    'Guards & barriers',
];

export const followingProcedures = [
    'Poor/inadequate/improper planning',
    'No SOP/SWP/JHA',
    'SOP/SWP/JHA did not identify hazard',
    'Not following SOP/SWP/JHA',
    'Deviated from SOP/SWP/JHA',
    'Failure to identify change',
    'No pre-inspection',
    'Inadequate/no permit, permit not followed',
    'Manufacturer recommendations not followed',
    'Operation of equipment without authority',
    'Improper position of posture for task',
    'Overexertion/Overreaching of physical capability',
    'Improperlifting',
    'Improper Loading',
    'Shortcutting/rushing – correct way takes more time/effort',
];

export const toolsEquipmentVehicles = [
    'Improper use of equipment, tools, devices',
    'Modifying or altering tools/equipment improperly',
    'Use of defective equipment',
    'Use of defective tools',
    'Electrical issue with tool or equipment',
    'Improper placement of tools, equipment, or materials',
    'Operation of equipment at improper speed Servicing of equipment in operation',
    'Inadequate equipment',
    'Improperly prepared equipment/tools/vehicles',
    'Inadequate tools',
    'Not performing an adequate inspection',
    'Dropped tool/object',
    'Defective vehicle',
    'Inadequate vehicle for the purpose',
    'Wrong selection of equipment',
    'Wrong selection of tool(s)',
];

export const inattention = [
    'No training/non-designated/not qualified',
    'Improper/inadequate training',
    'Improper decision making or lack of judgement',
    'Distracted by other concerns',
    'Inattention to footing and surroundings',
    'Inattention to body/hand position (crush point)',
    'Inattention to body position (line of fire)',
    'Inattention to stored energy / Horseplay',
    'Acts of violenceFailure to warn',
    'Use of drugs or alcohol',
    'Routine activity without thought',
    'Physical capability (fatigue, vision, hearing, disability)',
    'Improper assignment of personnel',
    'Inadequate communication',
    'Lack of knowledge of hazards present',
];

export const protectiveMethods = [
    'PPE not used',
    'Improper use of PPE',
    'Servicing of energized equipment',
    'Equipment or materials not secured',
    'Disabled guards, warning systems or safety devices',
    'PPE not available',
    'Inadequate guards or protective devices (barricades)',
    'Defective guards or protective devices',
    'Inadequate PPE',
    'Defective PPE',
    'Inadequate warning system',
    'Defective warning system',
    'Inadequate isolation of process or equipment',
    'Inadequate safety devices',
    'Defective safety devices',
];

export const workExposure = [
    'Fire or explosion',
    'Noise',
    'Energized electrical systems',
    'Energized systems other than electrical',
    'No utility locate',
    'Radiation',
    'Temperature extremes',
    'High winds',
    'Hazardous chemicals',
    'Mechanical hazards',
    'Storms or acts of nature',
];

export const workPlaceEnvironment = [
    'Congestion or restricted motion (arrangement/placement)',
    'Inadequate or excessive illumination',
    'Inadequate ventilation',
    'Unprotected height',
    'Inadequate workplace layout',
    'Inadequate access/egress',
    'Inadequate walkways',
    'Inadequate housekeeping',
    'Uneven ground',
    'Wet or slippery surfaces',
    'Tripping hazard',
];

export const ppeValues: Record<
    Extract<
        keyof RootCauseAnalysisData,
        'ppe_in_good_condition' | 'ppe_in_use' | 'ppe_correct_type'
    >,
    string
> = {
    ppe_in_good_condition: 'In Good Condition:',
    ppe_in_use: 'In Use:',
    ppe_correct_type: 'The Right Type:',
};

export const executionOfWorkValues = {
    correct_tool_used: 'Select right tool:',
    policies_followed: 'Follow policies:',
    worked_safely: 'Work safely:',
    used_tool_properly: 'Use tool properly:',
    tool_in_good_condition: 'Verify tool is in good condition:',
};
