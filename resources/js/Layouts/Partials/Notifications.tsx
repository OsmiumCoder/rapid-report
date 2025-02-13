import axios from 'axios';
import { Notification } from '@/types/Notification';
import { useEffect, useState } from 'react';

const items = [{ id: 1 }, { id: 2 }, { id: 3 }, { id: 4 }];
export default function Notifications() {
    const [notifications, setNotifications] = useState<Notification[]>([]);
    const [isLoadingNotifications, setIsLoadingNotifications] = useState(false);
    const [currentPage, setCurrentPage] = useState(1);

    const fetchNotifications = async () => {
        setIsLoadingNotifications(true);
        try {
            const response = await axios.get<Notification[]>(
                route('notifications.index', { page: currentPage })
            );
            setNotifications((prev) => [...prev, ...response.data]);
            setCurrentPage((prev) => prev + 1);
        } catch (e) {
            console.error(e);
        } finally {
            setIsLoadingNotifications(false);
        }
    };

    useEffect(() => {
        fetchNotifications();
    }, []);

    return (
        <ul role="list" className="divide-y divide-gray-200">
            {items.map((item) => (
                <li key={item.id} className="py-4">
                    <div>An incident has been created</div>
                </li>
            ))}
        </ul>
    );
}
