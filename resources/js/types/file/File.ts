import { FileExtension } from '@/types/file/FileExtension';

export interface File {
    original_name: string;
    extension: FileExtension;
    url: string;
    created_at: string;
}
