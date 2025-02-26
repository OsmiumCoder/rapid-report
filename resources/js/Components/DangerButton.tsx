import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes } from 'react';

export default function DangerButton({ className = '', children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'cursor-pointer rounded-md bg-upei-red-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-upei-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-red-600',
                className,
            )}
        >
            {children}
        </button>
    );
}
