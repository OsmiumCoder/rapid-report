import { usePage, WhenVisible } from '@inertiajs/react';
import LoadingIndicator from '@/Components/LoadingIndicator';

const items = [{ id: 1 }, { id: 2 }, { id: 3 }, { id: 4 }];
export default function Notifications() {
    const { notifications, paginated_notifications } = usePage().props;

    console.log(paginated_notifications.current_page);
    return (
        <ul role="list" className="max-h-64 overflow-y-scroll divide-y divide-gray-200">
            {notifications.map((notification, index) => (
                <li key={index} className="py-4">
                    <div>
                        {notifications.some((n, i) => i !== index && n.id === notification.id)
                            ? 'true'
                            : 'false'}
                    </div>
                </li>
            ))}

            <WhenVisible
                always
                data="notifications"
                fallback={<LoadingIndicator />}
                params={{
                    data: {
                        page: paginated_notifications.current_page + 1,
                    },
                    only: ['notifications', 'paginated_notifications'],
                }}
            >
                Reached end
            </WhenVisible>
        </ul>
    );
}
