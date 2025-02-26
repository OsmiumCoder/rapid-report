import timeSince from '@/Filters/timeSince';
import { Notification } from '@/types/notification/Notification';
import { TrashIcon } from '@heroicons/react/24/outline';
import { Link, router } from '@inertiajs/react';

interface NotificationListProps {
    notifications: Notification[];
    title: string;
}
export default function NotificationList({ notifications, title }: NotificationListProps) {
    const deleteNotification = (id: string) => {
        try {
            router.delete(route('notifications.destroy', { notification: id }), {
                onSuccess: () =>
                    router.reload({
                        only: ['notifications', 'notifications_paginator'],
                        reset: ['notifications', 'notifications_paginator'],
                        data: { notifications: 1 },
                    }),
            });
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <div className="relative">
            <div className="sticky top-0 z-10 border-y border-t-gray-100 border-b-gray-200 bg-gray-50 px-3 py-1.5 text-sm/6 font-semibold text-gray-900">
                <h3>{title}</h3>
            </div>
            <ul role="list" className="divide-y divide-gray-100">
                {notifications.map((notification) => (
                    <Link
                        key={notification.id}
                        as="li"
                        href={notification.data.url}
                        data={{ notification: notification.id }}
                        className="flex w-full py-5 hover:cursor-pointer hover:bg-gray-200"
                    >
                        <div className="flex w-full items-center justify-between px-4">
                            <div className="w-full px-2">
                                <p className="text-sm/6 font-semibold text-gray-900">{notification.data.message}</p>
                                <p className="mt-1 truncate text-xs/5 text-gray-500">{timeSince(notification.created_at)}</p>
                            </div>
                            <button
                                onClick={(e) => {
                                    e.stopPropagation();
                                    deleteNotification(notification.id);
                                }}
                                className="cursor-pointer p-2"
                            >
                                <TrashIcon className="text-upei-red-500 hover:text-upei-red-700 size-6" />
                            </button>
                        </div>
                    </Link>
                ))}
            </ul>
        </div>
    );
}
