import LoadingIndicator from '@/Components/LoadingIndicator';
import NotificationActions from '@/Layouts/Partials/NotificationComponents/NotificationActions';
import NotificationList from '@/Layouts/Partials/NotificationComponents/NotificationList';
import { Notification } from '@/types/notification/Notification';
import { router, usePage, WhenVisible } from '@inertiajs/react';
import { useEffect, useState } from 'react';

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
            <div className="absolute top-full right-0 mt-2 max-h-[25rem] w-72 overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-lg sm:max-h-[30rem] sm:w-[25rem]">
                <div className="flex items-center justify-between border-b border-gray-200">
                    <div className="p-3 font-medium">Notifications</div>
                    {notifications && notifications?.length > 1 && <NotificationActions />}
                </div>

                {notifications && notifications?.length > 0 ? (
                    <>
                        {unreadNotifications.length > 0 && <NotificationList notifications={unreadNotifications} title="New" />}

                        {readNotifications.length > 0 && <NotificationList notifications={readNotifications} title="Seen" />}
                        {notifications_paginator && notifications_paginator.current_page < notifications_paginator.last_page && (
                            <WhenVisible
                                always
                                fallback={<LoadingIndicator className="my-2 w-full text-center" />}
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
