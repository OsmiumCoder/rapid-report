import { Link, router, usePage, WhenVisible } from '@inertiajs/react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import { useEffect, useState } from 'react';
import { Notification } from '@/types/notification/Notification';
import timeSince from '@/Filters/timeSince';
import NotificationActions from '@/Layouts/Partials/NotificationComponents/NotificationActions';
import { TrashIcon } from '@heroicons/react/24/outline';

export default function Notifications() {
    const { notifications, notifications_paginator } = usePage().props;
    const [readNotifications, setReadNotifications] = useState<Notification[]>([]);
    const [unreadNotifications, setUnreadNotifications] = useState<Notification[]>([]);

    useEffect(() => {
        setReadNotifications(notifications?.filter(({ read_at }) => read_at !== null) ?? []);
        setUnreadNotifications(notifications?.filter(({ read_at }) => read_at === null) ?? []);
    }, [notifications]);

    const deleteNotification = (id: string) => {
        try {
            router.delete(route('notifications.destroy', { notification: id }), {
                onSuccess: () =>
                    router.reload({ only: ['notifications, notifications_paginator'] }),
            });
        } catch (error) {
            console.error(error);
        }
    };

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
                            <div className="relative">
                                <div className="sticky top-0 z-10 border-y border-b-gray-200 border-t-gray-100 bg-gray-50 px-3 py-1.5 text-sm/6 font-semibold text-gray-900">
                                    <h3>New</h3>
                                </div>
                                <ul role="list" className="divide-y divide-gray-100">
                                    {unreadNotifications.map((notification) => (
                                        <Link
                                            key={notification.id}
                                            as="li"
                                            href={route(notification.data.route, {
                                                ...notification.data.params,
                                                notification: notification.id,
                                            })}
                                            className="flex py-5 w-full  hover:bg-gray-200 hover:cursor-pointer"
                                        >
                                            <div className="flex items-center justify-between w-full px-4">
                                                <div className="w-full px-2">
                                                    <p className="text-sm/6 font-semibold text-gray-900">
                                                        {notification.data.message}
                                                    </p>
                                                    <p className="mt-1 truncate text-xs/5 text-gray-500">
                                                        {timeSince(notification.created_at)}
                                                    </p>
                                                </div>
                                                <button
                                                    onClick={(e) => {
                                                        e.stopPropagation();
                                                        deleteNotification(notification.id);
                                                    }}
                                                    className="p-2"
                                                >
                                                    <TrashIcon className="size-6 text-upei-red-500 hover:text-upei-red-700" />
                                                </button>
                                            </div>
                                        </Link>
                                    ))}
                                </ul>
                            </div>
                        )}

                        {readNotifications.length > 0 && (
                            <div className="relative">
                                <div className="sticky top-0 z-10 border-y border-b-gray-200 border-t-gray-100 bg-gray-50 px-3 py-1.5 text-sm/6 font-semibold text-gray-900">
                                    <h3>Old</h3>
                                </div>
                                <ul role="list" className="divide-y divide-gray-100">
                                    {readNotifications.map((notification) => (
                                        <Link
                                            key={notification.id}
                                            as="li"
                                            href={route(
                                                notification.data.route,
                                                notification.data.params
                                            )}
                                            className="flex justify-center py-5  hover:bg-gray-200 hover:cursor-pointer"
                                        >
                                            <div className="flex items-center justify-between w-full px-4">
                                                <div className="w-full px-2">
                                                    <p className="text-sm/6 font-semibold text-gray-900">
                                                        {notification.data.message}
                                                    </p>
                                                    <p className="mt-1 truncate text-xs/5 text-gray-500">
                                                        {timeSince(notification.created_at)}
                                                    </p>
                                                </div>
                                                <button
                                                    onClick={(e) => {
                                                        e.stopPropagation();
                                                        deleteNotification(notification.id);
                                                    }}
                                                >
                                                    <TrashIcon className="size-6 text-upei-red-500 hover:text-upei-red-700" />
                                                </button>
                                            </div>
                                        </Link>
                                    ))}
                                </ul>
                            </div>
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
