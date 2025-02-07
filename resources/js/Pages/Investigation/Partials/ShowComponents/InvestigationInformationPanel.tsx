import { Investigation } from '@/types/Investigation/Investigation';
import { ArrowLeftIcon } from '@heroicons/react/24/solid';
import { router } from '@inertiajs/react';

export default function InvestigationInformationPanel({
    investigation,
}: {
    investigation: Investigation;
}) {
    return (
        <div className="bg-white -mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
            <div className="flex items-center space-x-2">
                <button
                    onClick={() =>
                        router.get(route('incidents.show', { incident: investigation.incident_id }))
                    }
                >
                    <ArrowLeftIcon className="size-6" />
                </button>
                <h2 className="font-semibold text-gray-900 text-2xl">Investigation</h2>
            </div>
            <h3 className='className="font-semibold text-gray-800 my-4'>
                Incident: {investigation.incident_id}
            </h3>
            <br />
            <div className="space-y-6 text-gray-900">
                <div className="space-y-2">
                    <div className="font-semibold text-xl">General Information</div>
                    <div>
                        <span className="font-semibold">Resulted In: </span>
                        <span>{investigation.resulted_in.join(', ')}</span>
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
                <div className="space-y-2">
                    <div className="font-semibold text-xl">Root Causes</div>
                    <div>
                        <span className="font-semibold">Immediate Causes: </span>
                        <span>{investigation.immediate_causes}</span>
                    </div>
                    <div>
                        <span className="font-semibold">Basic Causes: </span>
                        <span>{investigation.basic_causes}</span>
                    </div>
                    <div>
                        <span className="font-semibold">Remedial Causes: </span>
                        <span>{investigation.immediate_causes}</span>
                    </div>
                </div>
                <div>
                    <div className="font-semibold text-xl">Prevention</div>
                    <span>{investigation.prevention}</span>
                </div>
            </div>
        </div>
    );
}
