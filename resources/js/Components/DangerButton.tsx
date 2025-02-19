import { ButtonHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function DangerButton({
    className = '',
    children,
    ...props
}: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'rounded-md bg-upei-red-500 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm',
                'hover:bg-upei-red-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-red-500',
                'disabled:opacity-25 disabled:hover:bg-upei-red-500',
                className
            )}
        >
            {children}
        </button>
    );
}
