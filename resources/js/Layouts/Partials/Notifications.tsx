import { router, usePage, WhenVisible } from '@inertiajs/react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import { useEffect, useState } from 'react';
import { Notification } from '@/types/notification/Notification';
import NotificationActions from '@/Layouts/Partials/NotificationComponents/NotificationActions';
import NotificationList from '@/Layouts/Partials/NotificationComponents/NotificationList';

export default function Notifications() {
    const { notifications, notifications_paginator } = usePage().props;
    const [readNotifications, setReadNotifications] = useState<Notification[]>([]);
    const [unreadNotifications, setUnreadNotifications] = useState<Notification[]>([]);

    useEffect(() => {
        setReadNotifications(notifications?.filter(({ read_at }) => read_at !== null) ?? []);
        setUnreadNotifications(notifications?.filter(({ read_at }) => read_at === null) ?? []);
    }, [notifications]);

    useEffect(() => {
        router.reload({ only: [], data: { notifications: '' } });
    }, []);

    return (
        <>
            <div className="absolute right-0 top-full mt-2 w-72 sm:w-[25rem] max-h-[25rem] sm:max-h-[30rem] overflow-y-auto bg-white border border-gray-200 shadow-lg rounded-lg">
                <div className="flex items-center justify-between border-b border-gray-200">
                    <div className="font-medium p-3 ">Notifications</div>
                    {notifications && notifications?.length > 1 && <NotificationActions />}
                </div>

                {notifications && notifications?.length > 0 ? (
                    <>
                        {unreadNotifications.length > 0 && (
                            <NotificationList notifications={unreadNotifications} title="New" />
                        )}

                        {readNotifications.length > 0 && (
                            <NotificationList notifications={readNotifications} title="Seen" />
                        )}
                        {notifications_paginator &&
                            notifications_paginator.current_page <
                                notifications_paginator.last_page && (
                                <WhenVisible
                                    always
                                    fallback={<LoadingIndicator />}
                                    params={{
                                        data: {
                                            notifications: notifications_paginator.current_page + 1,
                                        },
                                        only: ['notifications', 'notifications_paginator'],
                                    }}
                                >
                                    <></>
                                </WhenVisible>
                            )}
                    </>
                ) : (
                    <div className="p-2 text-center">You have no notifications yet.</div>
                )}
            </div>
        </>
    );
}
{
}
