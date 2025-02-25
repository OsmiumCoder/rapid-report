import { RootCauseAnalysis } from '@/types/rootCauseAnalysis/RootCauseAnalysis';
import { ArrowLeftIcon } from '@heroicons/react/24/solid';
import { Link } from '@inertiajs/react';

export default function RootCauseAnalysisInformationPanel({ rca }: { rca: RootCauseAnalysis }) {
    return (
        <div className="-mx-4 bg-white px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pt-16 xl:pb-20">
            <div className="flex items-center space-x-2">
                <Link href={route('incidents.show', { incident: rca.incident_id })}>
                    <ArrowLeftIcon className="size-6 text-gray-900 hover:text-gray-500" />
                </Link>
                <h2 className="text-2xl font-semibold text-gray-900">Root Cause Analysis</h2>
            </div>
            <div className='className="font-semibold my-4 text-gray-800'>Incident: {rca.incident_id}</div>
            <div className='className="font-semibold my-4 text-gray-800'>Root Cause Analysis provided by: {rca.supervisor.name}</div>

            <div className="space-y-6 text-gray-900">
                <div className="space-y-2">
                    <div className="text-lg font-semibold">Primary Effect:</div>
                    <div className="ml-6">{rca.primary_effect ?? 'N/A'}</div>
                </div>

                <div className="space-y-2">
                    <div className="text-lg font-semibold">5 Whys:</div>
                    <div className="ml-6">
                        {rca.whys[0]
                            ? rca.whys.map(
                                  (why, i) =>
                                      why && (
                                          <div key={why}>
                                              <span>{`${i + 1}. `}</span>
                                              <span>{why}</span>
                                          </div>
                                      ),
                              )
                            : 'None Specified'}
                    </div>
                </div>

                <div className="space-y-2">
                    <div className="text-lg font-semibold">Individuals Involved:</div>
                    <div className="ml-6 space-y-2">
                        {Object.values(rca.individuals_involved[0]).some((value) => {
                            return value !== undefined && value !== null && value !== '';
                        })
                            ? rca.individuals_involved.map(({ name, email, phone }, i) => (
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
                              ))
                            : 'None Specified'}
                    </div>
                </div>

                <div className="space-y-2">
                    <div className="text-lg font-semibold">Solutions and Actions:</div>
                    <div className="ml-6 space-y-2">
                        {Object.values(rca.solutions_and_actions[0]).some((value) => {
                            return value !== undefined && value !== null && value !== '';
                        })
                            ? rca.solutions_and_actions.map(({ cause, control, remedial_action, by_who, by_when }, i) => (
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
                                  </div>
                              ))
                            : 'None Specified'}
                    </div>
                </div>

                <div>
                    <span className="text-lg font-semibold">Peoples Positions: </span>
                    <span>{rca.peoples_positions.length > 0 ? rca.peoples_positions.join(', ') : 'None Specified'}</span>
                </div>

                <div>
                    <span className="text-lg font-semibold">Attention to Work: </span>
                    <span>{rca.attention_to_work.length > 0 ? rca.attention_to_work.join(', ') : 'None Specified'}</span>
                </div>

                <div>
                    <span className="text-lg font-semibold">Communication: </span>
                    <span>{rca.communication.length > 0 ? rca.communication.join(', ') : 'None Specified'}</span>
                </div>
                <div>
                    <div className="text-lg font-semibold">Personal Protective Equipment:</div>
                    <div className="ml-6">
                        <div>Good Condition: {rca.ppe_in_good_condition !== null ? (rca.ppe_in_good_condition ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>In Use: {rca.ppe_in_use !== null ? (rca.ppe_in_use ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>Correct Type: {rca.ppe_correct_type !== null ? (rca.ppe_correct_type ? 'Yes' : 'No') : 'N/A'}</div>
                    </div>
                </div>
                <div>
                    <div className="text-lg font-semibold">Execution of Work:</div>
                    <div className="ml-6">
                        <div>Correct Tool Used: {rca.correct_tool_used !== null ? (rca.correct_tool_used ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>Policies Followed: {rca.policies_followed !== null ? (rca.policies_followed ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>Worked Safely: {rca.worked_safely !== null ? (rca.worked_safely ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>Used Tool Properly: {rca.used_tool_properly !== null ? (rca.used_tool_properly ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>Tool in Good Condition: {rca.tool_in_good_condition !== null ? (rca.tool_in_good_condition ? 'Yes' : 'No') : 'N/A'}</div>
                        <div>Worked Safely: {rca.worked_safely !== null ? (rca.worked_safely ? 'Yes' : 'No') : 'N/A'}</div>
                    </div>
                </div>
                <div>
                    <span className="text-lg font-semibold">Working Conditions: </span>
                    <span>{rca.working_conditions.length > 0 ? rca.working_conditions.join(', ') : 'None Specified'}</span>
                </div>
                <div>
                    <span className="text-lg font-semibold">Root Causes: </span>
                    <span>{rca.root_causes.length > 0 ? rca.root_causes.join(', ') : 'None Specified'}</span>
                </div>
            </div>
        </div>
    );
}
