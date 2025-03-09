import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import LoadingIndicator from '@/Components/LoadingIndicator';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import TextArea from '@/Components/TextArea';
import { IncidentStatus } from '@/Enums/IncidentStatus';
import FileUploadModal from '@/Pages/Incident/Partials/ShowComponents/FileUploadModal';
import IncidentFiles from '@/Pages/Incident/Partials/ShowComponents/IncidentFiles';
import { Incident } from '@/types/incident/Incident';
import { router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function IncidentUserActions({ incident }: { incident: Incident }) {
    const [isInfoModalOpen, setIsInfoModalOpen] = useState(false);
    const [isUploadModalOpen, setIsUploadModalOpen] = useState(false);

    const { data, setData, patch, processing, cancel, errors, clearErrors } = useForm({
        additional_information: '',
    });

    const handleSubmit = () => {
        patch(route('incidents.additional-information', { incident: incident.slug }), {
            onSuccess: () => {
                setIsInfoModalOpen(false);
                setData('additional_information', '');
                clearErrors();
                router.reload({ only: ['incident'] });
                window.scrollTo({
                    top: document.body.scrollHeight,
                    behavior: 'smooth',
                });
            },
        });
    };

    const handleCancel = () => {
        if (processing) {
            cancel();
        }

        setIsInfoModalOpen(false);
        clearErrors();
        setData('additional_information', '');
    };

    return (
        <>
            <div className="rounded-lg bg-white lg:col-start-3 lg:row-end-1">
                <div className="rounded-lg shadow-xs ring-1 ring-gray-900/5">
                    <div className="flex flex-col flex-wrap items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">User Actions</div>
                        <div className="mt-6 flex w-full flex-col gap-y-6 border-t border-gray-900/5 p-6">
                            {incident.status !== IncidentStatus.CLOSED && (
                                <>
                                    <PrimaryButton onClick={() => setIsInfoModalOpen(true)}>Add Additional Information</PrimaryButton>
                                    <PrimaryButton onClick={() => setIsUploadModalOpen(true)}>Upload Files</PrimaryButton>
                                </>
                            )}
                        </div>
                        <IncidentFiles incident={incident} />
                    </div>
                </div>
            </div>
            <Modal show={isInfoModalOpen} onClose={() => setIsInfoModalOpen(false)}>
                <div className="space-y-4 p-6">
                    <div className="text-center text-lg font-medium text-gray-900">Add Additional Information</div>
                    <div>
                        <InputLabel>Please enter any additional information regarded to this incident</InputLabel>
                        <TextArea value={data.additional_information} onChange={(e) => setData('additional_information', e.target.value)} />
                        <InputError message={errors.additional_information} />
                    </div>
                    <div className="flex justify-between">
                        <DangerButton onClick={handleCancel}>Cancel</DangerButton>

                        <PrimaryButton onClick={handleSubmit} disabled={processing}>
                            Submit
                        </PrimaryButton>
                    </div>
                    {processing && <LoadingIndicator />}
                </div>
            </Modal>
            <FileUploadModal incident={incident} isOpen={isUploadModalOpen} onClose={() => setIsUploadModalOpen(false)} />
        </>
    );
}
