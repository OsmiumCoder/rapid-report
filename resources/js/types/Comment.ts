import { User } from '@/types/index';

export interface Comment {
    id: string;
    content: string;
    type: number;
    user_id?: number;
    user?: User;
    commentable_id: string;
    commentable_type: string;
    created_at: string;
    updated_at: string;
    deleted_at?: string;
}
