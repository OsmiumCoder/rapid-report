import { PaginatedResponse } from '@/types/PaginatedResponse';
import { Notification } from '@/types/notification/Notification';
import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    upei_id: string;
    phone?: string;
    roles: Role[];
}

export interface Role {
    id: number;
    name: RoleName;
}

type RoleName = 'admin' | 'supervisor' | 'user' | 'all';

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    notifications?: Notification[];
    notifications_paginator?: PaginatedResponse<Notification>;
    ziggy: Config & { location: string };
};
