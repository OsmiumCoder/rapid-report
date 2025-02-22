import { Incident } from '@/types/incident/Incident';
import { router, useForm } from '@inertiajs/react';
import PrimaryButton from '@/Components/PrimaryButton';
import Modal from '@/Components/Modal';
import { useState } from 'react';
import TextArea from '@/Components/TextArea';
import DangerButton from '@/Components/DangerButton';
import InputLabel from '@/Components/InputLabel';
import LoadingIndicator from '@/Components/LoadingIndicator';
import InputError from '@/Components/InputError';

export default function IncidentUserActions({ incident }: { incident: Incident }) {
    const [isModalOpen, setIsModalOpen] = useState(false);
    const { data, setData, patch, processing, cancel, errors, clearErrors } = useForm({
        additional_information: '',
    });

    const handleSubmit = () => {
        patch(route('incidents.additional-information', { incident: incident.id }), {
            onSuccess: () => {
                setIsModalOpen(false);
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

        setIsModalOpen(false);
        clearErrors();
        setData('additional_information', '');
    };

    return (
        <>
            <div className=" lg:col-start-3 lg:row-end-1 bg-white rounded-lg">
                <div className="rounded-lg  shadow-sm ring-1 ring-gray-900/5">
                    <div className="flex flex-wrap flex-col items-center justify-between">
                        <div className="mt-1 pt-6 text-base font-semibold text-gray-900">
                            User Actions
                        </div>
                        <div className="flex flex-col gap-y-6 w-full mt-6 border-t border-gray-900/5 p-6">
                            <PrimaryButton onClick={() => setIsModalOpen(true)}>
                                Add Additional Information
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
            <Modal show={isModalOpen} onClose={() => setIsModalOpen(false)}>
                <div className="p-6 space-y-4">
                    <div className="text-center font-medium text-gray-900 text-lg">
                        Add Additional Information
                    </div>
                    <div>
                        <InputLabel>
                            Please enter any additional information regarded to this incident
                        </InputLabel>
                        <TextArea
                            value={data.additional_information}
                            onChange={(e) => setData('additional_information', e.target.value)}
                        />
                        <InputError message={errors.additional_information} />
                    </div>
                    <div className="flex justify-between">
                        <DangerButton onClick={handleCancel}>Cancel</DangerButton>

                        <PrimaryButton onClick={handleSubmit} disabled={processing}>
                            Submit
                        </PrimaryButton>
                    </div>
                    {processing && <LoadingIndicator className="w-full text-center" />}
                </div>
            </Modal>
        </>
    );
}
