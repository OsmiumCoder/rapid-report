import { FileExtension } from '@/types/file/FileExtension';
export interface File {
    name: string;
    original_name: string;
    path: string;
    size: number;
    mime_type: string;
    extension: FileExtension;
}
