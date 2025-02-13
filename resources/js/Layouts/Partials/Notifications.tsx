import { usePage, WhenVisible } from '@inertiajs/react';
import LoadingIndicator from '@/Components/LoadingIndicator';

const items = [{ id: 1 }, { id: 2 }, { id: 3 }, { id: 4 }];
export default function Notifications() {
    const { notifications, notifications_paginator } = usePage().props;

    return (
        <ul role="list" className="max-h-64 overflow-y-scroll divide-y divide-gray-200">
            {notifications.map((notification, index) => (
                <li key={index} className="py-4">
                    <div>
                        {JSON.stringify(notification)}
                    </div>
                </li>
            ))}

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
                Reached end
            </WhenVisible>
        </ul>
    );
}
