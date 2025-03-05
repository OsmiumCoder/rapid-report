import { Incident } from '@/types/incident/Incident';

import FileIcon from '@/Components/FileIcon';
import PrimaryButton from '@/Components/PrimaryButton';
import dateFormat from '@/Formatters/dateFormat';
import dateTimeFormat from '@/Formatters/dateTimeFormat';
import FileUploadModal from '@/Pages/Incident/Partials/ShowComponents/FileUploadModal';
import { Link } from '@inertiajs/react';
import { useState } from 'react';

interface SupervisorActionsProps {
    incident: Incident;
    canRequestReview: boolean;
    canProvideFollowup: boolean;
}

export default function IncidentSupervisorActions({ incident, canRequestReview, canProvideFollowup }: SupervisorActionsProps) {
    const [isUploadModalOpen, setIsUploadModalOpen] = useState(false);

    return (
        <>
            <FileUploadModal isOpen={isUploadModalOpen} onClose={() => setIsUploadModalOpen(false)} incident={incident} />
            <div className="rounded-lg bg-white lg:col-start-3 lg:row-end-1">
                <div className="rounded-lg shadow-xs ring-1 ring-gray-900/5">
                    <div className="flex flex-col flex-wrap items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">Supervisor Actions</div>
                        {incident.investigations.length > 0 && (
                            <div className="mt-6 flex w-full flex-col gap-y-6 border-t border-gray-900/5 p-6">
                                <div className="font-semibold">
                                    Investigations
                                    {incident.investigations.map((investigation) => (
                                        <div key={investigation.id} className="font-normal">
                                            <Link
                                                className="cursor-pointer text-sm text-blue-500 hover:text-blue-400"
                                                href={route('incidents.investigations.show', {
                                                    incident: incident.slug,
                                                    investigation: investigation.id,
                                                })}
                                            >
                                                {investigation.supervisor.name}: {dateTimeFormat(investigation.created_at)}
                                            </Link>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        {incident.root_cause_analyses.length > 0 && (
                            <div className="mt-6 flex w-full flex-col gap-y-6 px-6 pb-6">
                                <div className="font-semibold">
                                    Root Cause Analyses
                                    {incident.root_cause_analyses.map((rca) => (
                                        <div key={rca.id} className="font-normal">
                                            <Link
                                                className="cursor-pointer text-sm text-blue-500 hover:text-blue-400"
                                                href={route('incidents.root-cause-analyses.show', {
                                                    incident: incident.slug,
                                                    root_cause_analysis: rca.id,
                                                })}
                                            >
                                                {rca.supervisor.name}: {dateTimeFormat(rca.created_at)}
                                            </Link>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        {incident.files.length > 0 && (
                            <div className="mt-6 flex w-full flex-col gap-y-6 px-6 pb-6">
                                <div className="font-semibold">
                                    Files
                                    {incident.files.map((file) => (
                                        <div key={file.url} className="font-normal">
                                            <a
                                                href={route('incidents.download-files', { incident: incident.id, file: file.id })}
                                                target="_blank"
                                                className="cursor-pointer text-sm text-blue-500 hover:text-blue-400"
                                            >
                                                <div className="mt-3 flex items-center">
                                                    <FileIcon extension={file.extension} className="mr-6 size-6" />
                                                    {dateFormat(file.created_at)} - {file.original_name}
                                                </div>
                                            </a>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}

                        {(canProvideFollowup || canRequestReview) && (
                            <div className="mt-6 flex w-full flex-col gap-y-6 border-t border-gray-900/5 p-6">
                                {canProvideFollowup && (
                                    <>
                                        <Link
                                            href={route('incidents.investigations.create', {
                                                incident: incident.slug,
                                            })}
                                            as="button"
                                            className="bg-upei-green-500 hover:bg-upei-green-400 focus-visible:outline-upei-green-600 cursor-pointer rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                        >
                                            Submit Investigation
                                        </Link>
                                        <Link
                                            href={route('incidents.root-cause-analyses.create', {
                                                incident: incident.slug,
                                            })}
                                            as="button"
                                            className="bg-upei-green-500 hover:bg-upei-green-400 focus-visible:outline-upei-green-600 cursor-pointer rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                        >
                                            Submit Root Cause Analysis
                                        </Link>
                                        <PrimaryButton
                                            onClick={() => setIsUploadModalOpen(true)}
                                            className="bg-upei-green-500 hover:bg-upei-green-400 focus-visible:outline-upei-green-600 cursor-pointer rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                        >
                                            Upload Files
                                        </PrimaryButton>
                                    </>
                                )}
                                {canRequestReview && (
                                    <Link
                                        href={route('incidents.request-review', {
                                            incident: incident.slug,
                                        })}
                                        method="patch"
                                        as="button"
                                        className="bg-upei-red-500 hover:bg-upei-red-400 focus-visible:outline-upei-red-600 cursor-pointer rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                                    >
                                        Request Review
                                    </Link>
                                )}
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </>
    );
}
