import { Config } from 'ziggy-js';
import {PaginatedResponse} from "@/types/PaginatedResponse";
import {Incident} from "@/types/incident/Incident";

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

type RoleName = 'super-admin' | 'admin' | 'supervisor' | 'user' | 'all';

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
    notifications: PaginatedResponse<Incident>
    ziggy: Config & { location: string };
};
