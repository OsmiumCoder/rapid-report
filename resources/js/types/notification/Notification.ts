import { NotificationData } from '@/types/notification/NotificationData';

export interface Notification {
    id: string;
    notifiable_id: number;
    notifiable_type: string;
    type: string;
    read_at?: string;
    created_at: string;
    updated_at: string;
    data: NotificationData;
}
