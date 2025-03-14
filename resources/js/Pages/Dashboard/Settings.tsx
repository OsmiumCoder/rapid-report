import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import LoadingIndicator from '@/Components/LoadingIndicator';
import PrimaryButton from '@/Components/PrimaryButton';
import TextArea from '@/Components/TextArea';
import { uppercaseWordFormat } from '@/Formatters/uppercaseWordFormat';
import Authenticated from '@/Layouts/AuthenticatedLayout';
import { NotificationMessage } from '@/types/notification/NotificationMessage';
import { Head, router, useForm } from '@inertiajs/react';
import { useState } from 'react';

export default function Settings({ notificationMessages }: { notificationMessages: NotificationMessage[] }) {
    const { data, setData, put, processing, errors, cancel, clearErrors } = useForm({
        message: '',
    });

    const [notificationBeingEdited, setNotificationBeingEdited] = useState<NotificationMessage | null>(null);

    const handleNotificationBeingEditied = (notificationMessage: NotificationMessage) => {
        setNotificationBeingEdited(notificationMessage);
        setData('message', notificationMessage.message);
    };

    const handleUpdateNotificationMessage = (notificationMessage: NotificationMessage) => {
        put(route('notifications.update-message', { notification_message: notificationMessage.id }), {
            onSuccess: () => {
                setNotificationBeingEdited(null);
                router.reload({ only: ['notificationMessages'] });
            },
        });
    };

    const handleCancelUpdateNotificationMessage = () => {
        if (processing) {
            cancel();
        }

        setNotificationBeingEdited(null);
        setData('message', '');
        clearErrors();
    };

    return (
        <Authenticated>
            <Head title="Settings" />
            <div className="px-4 sm:px-6 lg:px-8">
                <div className="pb-2 text-lg font-semibold text-gray-800">Settings</div>
                <div className="rounded-md bg-white p-6 shadow-xs ring-1 ring-gray-900/5 sm:rounded-lg">
                    {notificationMessages.map((notificationMessage, i) => (
                        <div key={i} className="space-y-2 p-2">
                            <div className="font-semibold text-gray-900">{uppercaseWordFormat(notificationMessage.name, '-')} Message</div>
                            <InputLabel>Update the content of the {uppercaseWordFormat(notificationMessage.name, '-')} notification.</InputLabel>
                            {notificationMessage.data.length > 0 && (
                                <InputLabel>
                                    <span className={'font-semibold'}>Available Variables: </span>
                                    <span>{notificationMessage.data.join(', ')}</span>
                                </InputLabel>
                            )}
                            <TextArea
                                disabled={processing || notificationBeingEdited?.id !== notificationMessage.id}
                                value={notificationBeingEdited?.id === notificationMessage.id ? data.message : notificationMessage.message}
                                onChange={(e) => setData('message', e.target.value)}
                            />
                            <InputError message={errors.message} />

                            {processing ? (
                                <LoadingIndicator />
                            ) : notificationBeingEdited?.id === notificationMessage.id ? (
                                <div className="flex justify-between">
                                    <DangerButton onClick={handleCancelUpdateNotificationMessage}>Cancel</DangerButton>
                                    <PrimaryButton disabled={processing} onClick={() => handleUpdateNotificationMessage(notificationMessage)}>
                                        Update
                                    </PrimaryButton>
                                </div>
                            ) : (
                                <PrimaryButton onClick={() => handleNotificationBeingEditied(notificationMessage)}>Edit</PrimaryButton>
                            )}
                        </div>
                    ))}
                </div>
            </div>
        </Authenticated>
    );
}
