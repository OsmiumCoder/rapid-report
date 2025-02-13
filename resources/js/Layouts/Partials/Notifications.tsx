import axios from 'axios';
import { Notification } from '@/types/Notification';
import { useEffect, useState } from 'react';
import {usePage, WhenVisible} from '@inertiajs/react';
import LoadingIndicator from "@/Components/LoadingIndicator";
import {Incident} from "@/types/incident/Incident";

const items = [{ id: 1 }, { id: 2 }, { id: 3 }, { id: 4 }];
export default function Notifications() {
    const { notifications } = usePage().props;

    const [isLoadingNotifications, setIsLoadingNotifications] = useState(false);
    const [currentPage, setCurrentPage] = useState(1);

    const fetchNotifications = async () => {
        setIsLoadingNotifications(true);
        try {
            const response = await axios.get<Notification[]>(
                route('notifications.index', { page: currentPage })
            );
            setCurrentPage((prev) => prev + 1);
        } catch (e) {
            console.error(e);
        } finally {
            setIsLoadingNotifications(false);
        }
    };

    useEffect(() => {
        // fetchNotifications();
    }, []);

    return (

            <ul role="list" className="max-h-64 overflow-y-scroll divide-y divide-gray-200">
                <WhenVisible
                    always
                    data="notifications"
                             params={{
                                 data: {
                                     notifications: notifications.current_page - 1
                                 }
                             }}
                             fallback={<LoadingIndicator/>}
                >
                    <li></li>
                </WhenVisible>
                {notifications.data.map((notification, index) => (
                    <li key={index} className="py-4">
                        <div>{notification.id}</div>
                    </li>

                ))}

                <WhenVisible data="notifications"
                             params={{
                                 data: {
                                     notifications: notifications.current_page + 1
                                 }
                             }}
                             fallback={<LoadingIndicator/>}
                >
                    <li></li>
                </WhenVisible>

            </ul>

    );
}
