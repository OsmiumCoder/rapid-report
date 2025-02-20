import { Link } from '@inertiajs/react';
import { ArrowLeftIcon } from '@heroicons/react/24/solid';
import { RootCauseAnalysis } from '@/types/rootCauseAnalysis/RootCauseAnalysis';

export default function RootCauseAnalysisInformationPanel({ rca }: { rca: RootCauseAnalysis }) {
    return (
        <div className="bg-white -mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
            <div className="flex items-center space-x-2">
                <Link href={route('incidents.show', { incident: rca.incident_id })}>
                    <ArrowLeftIcon className="size-6 text-gray-900 hover:text-gray-500" />
                </Link>
                <h2 className="font-semibold text-gray-900 text-2xl">Root Cause Analysis</h2>
            </div>
            <h3 className='className="font-semibold text-gray-800 my-4'>
                Incident: {rca.incident_id}
            </h3>
            <br />
            <div className="space-y-6 text-gray-900">
                <div className="space-y-2">
                    <div className="font-semibold text-lg">Primary Effect:</div>
                    <div className="ml-6">{rca.primary_effect}</div>
                </div>

                <div className="space-y-2">
                    <div className="font-semibold text-lg">5 Whys:</div>
                    <div className="ml-6">
                        {rca.whys.map(
                            (why, i) =>
                                why && (
                                    <div key={why}>
                                        <span>{`${i + 1}. `}</span>
                                        <span>{why}</span>
                                    </div>
                                )
                        )}
                    </div>
                </div>

                <div className="space-y-2">
                    <div className="font-semibold text-lg">Individuals Involved: </div>
                    <div className="space-y-2 ml-6">
                        {rca.individuals_involved.map(({ name, email, phone }, i) => (
                            <div key={i + name}>
                                <div>
                                    <span>Name: </span>
                                    <span>{name}</span>
                                </div>
                                <div>
                                    <span>Email: </span>
                                    <span>{email}</span>
                                </div>
                                <div>
                                    <span>Phone: </span>
                                    <span>{phone}</span>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>

                <div className="space-y-2">
                    <div className="font-semibold text-lg">Solutions and Actions: </div>
                    <div className="ml-6 space-y-2">
                        {rca.solutions_and_actions.map(
                            ({ cause, control, remedial_action, by_who, by_when, manager }, i) => (
                                <div key={i + cause}>
                                    <div>
                                        <span>Cause: </span>
                                        <span>{cause}</span>
                                    </div>
                                    <div>
                                        <span>Control: </span>
                                        <span>{control}</span>
                                    </div>
                                    <div>
                                        <span>Remedial Action: </span>
                                        <span>{remedial_action}</span>
                                    </div>
                                    <div>
                                        <span>By Who: </span>
                                        <span>{by_who}</span>
                                    </div>
                                    <div>
                                        <span>By When: </span>
                                        <span>{by_when}</span>
                                    </div>
                                    <div>
                                        <span>Manager Name: </span>
                                        <span>{manager}</span>
                                    </div>
                                </div>
                            )
                        )}
                    </div>
                </div>

                <div>
                    <span className="font-semibold text-lg">Peoples Positions: </span>
                    <span>
                        {rca.peoples_positions.length > 0
                            ? rca.peoples_positions.join(', ')
                            : 'None Specified'}
                    </span>
                </div>

                <div>
                    <span className="font-semibold text-lg">Attention to Work: </span>
                    <span>
                        {rca.attention_to_work.length > 0
                            ? rca.attention_to_work.join(', ')
                            : 'None Specified'}
                    </span>
                </div>

                <div>
                    <span className="font-semibold text-lg">Communication: </span>
                    <span>
                        {rca.communication.length > 0
                            ? rca.communication.join(', ')
                            : 'None Specified'}
                    </span>
                </div>
                <div>
                    <div className="font-semibold text-lg">Personal Protective Equipment: </div>
                    <div className="ml-6">
                        <div>Good Condition: {rca.ppe_in_good_condition ? 'Yes' : 'No'}</div>
                        <div>In Use: {rca.ppe_in_use ? 'Yes' : 'No'}</div>
                        <div>Correct Type: {rca.ppe_correct_type ? 'Yes' : 'No'}</div>
                    </div>
                </div>
                <div>
                    <div className="font-semibold text-lg">Execution of Work: </div>
                    <div className="ml-6">
                        <div>Correct Tool Used: {rca.correct_tool_used ? 'Yes' : 'No'}</div>
                        <div>Policies Followed: {rca.policies_followed ? 'Yes' : 'No'}</div>
                        <div>Worked Safely: {rca.worked_safely ? 'Yes' : 'No'}</div>
                        <div>Used Tool Properly: {rca.used_tool_properly ? 'Yes' : 'No'}</div>
                        <div>
                            Tool in Good Condition: {rca.tool_in_good_condition ? 'Yes' : 'No'}
                        </div>
                        <div>Worked Safely: {rca.worked_safely ? 'Yes' : 'No'}</div>
                    </div>
                </div>
                <div>
                    <span className="font-semibold text-lg">Working Conditions: </span>
                    <span>{rca.working_conditions.join(', ')}</span>
                </div>
                <div>
                    <span className="font-semibold text-lg">Root Causes: </span>
                    <span>{rca.root_causes.join(', ')}</span>
                </div>
            </div>
        </div>
    );
}
