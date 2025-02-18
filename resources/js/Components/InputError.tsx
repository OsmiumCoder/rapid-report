import { HTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function InputError({
    message,
    className = '',
    ...props
}: HTMLAttributes<HTMLParagraphElement> & { message?: string }) {
    return message ? (
        <p {...props} className={classNames('text-sm text-red-600', className)}>
            {message}
        </p>
    ) : null;
}
