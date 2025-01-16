import { Config } from 'ziggy-js'

export interface User {
    id: number
    name: string
    email: string
    email_verified_at?: string
    roles: Role[]
}

export interface Role {
    name: string
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>,
> = T & {
    auth: {
        user: User
    }
    ziggy: Config & { location: string }
}
