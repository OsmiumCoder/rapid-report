import { ButtonHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function DangerButton({
    className = '',
    disabled,
    children,
    ...props
}: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'rounded-md bg-red-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm,' +
                    'hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600',
                disabled ? 'opacity-25' : '',
                className
            )}
            disabled={disabled}
        >
            {children}
        </button>
    );
}
