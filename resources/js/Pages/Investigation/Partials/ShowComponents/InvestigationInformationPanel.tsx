import { Investigation } from '@/types/investigation/Investigation';
import { ArrowLeftIcon } from '@heroicons/react/24/solid';
import { Link } from '@inertiajs/react';

export default function InvestigationInformationPanel({ investigation }: { investigation: Investigation }) {
    return (
        <div className="-mx-4 bg-white px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pt-16 xl:pb-20">
            <div className="flex items-center space-x-2">
                <Link href={route('incidents.show', { incident: investigation.incident.slug })}>
                    <ArrowLeftIcon className="size-6 text-gray-900 hover:text-gray-500" />
                </Link>
                <h2 className="font-semibold text-gray-900 text-2xl">Investigation</h2>
            </div>
            <div className='className="font-semibold text-gray-800 my-4'>
                Incident: {investigation.incident.slug}
            </div>
            <div className='className="font-semibold text-gray-800 my-4'>
                Investigation provided by: {investigation.supervisor.name}
            </div>
            <div className='className="font-semibold my-4 text-gray-800'>Incident: {investigation.incident_id}</div>
            <div className='className="font-semibold my-4 text-gray-800'>Investigation provided by: {investigation.supervisor.name}</div>

            <div className="space-y-6 text-gray-900">
                <div className="space-y-2">
                    <div className="text-xl font-semibold">General Information</div>
                    <div className="ml-6 space-y-2">
                        <div>
                            <span className="font-semibold">Resulted In: </span>
                            <span>{investigation.resulted_in.join(', ')}</span>
                        </div>

                        <div>
                            <span className="font-semibold">Substandard Acts: </span>
                            <span>{investigation.substandard_acts.join(', ') ?? 'N/A'}</span>
                        </div>

                        <div>
                            <span className="font-semibold">Substandard Conditions: </span>
                            <span>{investigation.substandard_conditions.join(', ') ?? 'N/A'}</span>
                        </div>

                        <div>
                            <span className="font-semibold">Energy Transfer Causes: </span>
                            <span>{investigation.energy_transfer_causes.join(', ') ?? 'N/A'}</span>
                        </div>

                        <div>
                            <span className="font-semibold">Personal Factors: </span>
                            <span>{investigation.personal_factors.join(', ') ?? 'N/A'}</span>
                        </div>

                        <div>
                            <span className="font-semibold">Job Factors: </span>
                            <span>{investigation.job_factors.join(', ') ?? 'N/A'}</span>
                        </div>

                        <div>
                            <span className="font-semibold">Hazard Class: </span>
                            <span>{investigation.hazard_class.toUpperCase()}</span>
                        </div>
                        <div>
                            <span className="font-semibold">Risk Rank: </span>
                            <span>{investigation.risk_rank}</span>
                        </div>
                    </div>
                </div>
                <div className="space-y-2">
                    <div className="text-xl font-semibold">Root Causes</div>
                    <div className="ml-6 space-y-2">
                        <div>
                            <span className="font-semibold">Immediate Causes: </span>
                            <span>{investigation.immediate_causes ?? 'N/A'}</span>
                        </div>
                        <div>
                            <span className="font-semibold">Basic Causes: </span>
                            <span>{investigation.basic_causes ?? 'N/A'}</span>
                        </div>
                        <div>
                            <span className="font-semibold">Remedial Actions: </span>
                            <span>{investigation.remedial_actions}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div className="text-xl font-semibold">Prevention</div>
                    <span className="ml-6">{investigation.prevention ?? 'N/A'}</span>
                </div>
            </div>
        </div>
    );
}
