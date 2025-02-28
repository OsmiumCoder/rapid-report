import { FileExtension } from '@/types/file/FileExtension';
import { DetailedHTMLProps, ImgHTMLAttributes } from 'react';

interface FileIconProps extends DetailedHTMLProps<ImgHTMLAttributes<HTMLImageElement>, HTMLImageElement> {
    extension: FileExtension;
}

export default function FileIcon({ extension, ...props }: FileIconProps) {
    return <img {...props} src={`/images/icons/${extension}-file.svg`} alt={`${extension} icon`} />;
}
