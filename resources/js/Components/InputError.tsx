import classNames from '@/Formatters/classNames';
import { HTMLAttributes } from 'react';

export default function InputError({ message, className = '', ...props }: HTMLAttributes<HTMLParagraphElement> & { message?: string }) {
    return message ? (
        <p {...props} className={classNames('text-upei-red-600 text-sm', className)}>
            {message}
        </p>
    ) : null;
}
