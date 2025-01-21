import { Config } from 'ziggy-js';

export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at?: string;
    roles: Role[];
}

export interface Role {
    id: number;
    name: RoleName;
}

type RoleName = 'super-admin' | 'admin' | 'supervisor' | 'user' | 'all';

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User;
    };
    ziggy: Config & { location: string };
};
