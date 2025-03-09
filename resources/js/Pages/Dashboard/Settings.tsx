import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import LoadingIndicator from '@/Components/LoadingIndicator';
import PrimaryButton from '@/Components/PrimaryButton';
import TextArea from '@/Components/TextArea';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { NotificationMessage } from '@/types/notification/NotificationMessage';
import { Head, router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Settings({ incidentReceivedMessage }: { incidentReceivedMessage: NotificationMessage }) {
    const { data, setData, put, processing, errors, cancel, clearErrors } = useForm({
        message: incidentReceivedMessage.message,
    });

    const [isEditingIncidentReceivedMessage, setIsEditingIncidentReceivedMessage] = useState(false);

    const handleUpdateIncidentReceivedMessage = () => {
        put(route('notifications.update-message', { notification_message: incidentReceivedMessage.id }), {
            onSuccess: () => {
                setIsEditingIncidentReceivedMessage(false);
                router.reload({ only: ['incidentReceivedMessage'] });
            },
        });
    };

    const handleCancelUpdateIncidentReceivedMessage = () => {
        if (processing) {
            cancel();
        }

        setIsEditingIncidentReceivedMessage(false);
        setData('message', incidentReceivedMessage.message);
        clearErrors();
    };

    return (
        <Authenticated>
            <Head title="Settings" />
            <div className="px-4 sm:px-6 lg:px-8">
                <div className="pb-2 text-lg font-semibold text-gray-800">Settings</div>
                <div className="rounded-md bg-white p-6 shadow-xs ring-1 ring-gray-900/5 sm:rounded-lg">
                    <div className="space-y-2 p-2">
                        <div className="font-semibold text-gray-900">Incident Received Message</div>
                        <InputLabel>Update the content of the incident received notification.</InputLabel>
                        <TextArea
                            disabled={processing || !isEditingIncidentReceivedMessage}
                            value={data.message}
                            onChange={(e) => setData('message', e.target.value)}
                        />
                        <InputError message={errors.message} />

                        {processing ? (
                            <LoadingIndicator />
                        ) : isEditingIncidentReceivedMessage ? (
                            <div className="flex justify-between">
                                <DangerButton onClick={handleCancelUpdateIncidentReceivedMessage}>Cancel</DangerButton>
                                <PrimaryButton disabled={processing} onClick={handleUpdateIncidentReceivedMessage}>
                                    Update
                                </PrimaryButton>
                            </div>
                        ) : (
                            <PrimaryButton onClick={() => setIsEditingIncidentReceivedMessage(true)}>Edit</PrimaryButton>
                        )}
                    </div>
                </div>
            </div>
        </Authenticated>
    );
}
