import classNames from '@/Formatters/classNames';
import { ButtonHTMLAttributes } from 'react';

export default function DangerButton({ className = '', children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'bg-upei-red-600 hover:bg-upei-red-500 focus-visible:outline-upei-red-600 cursor-pointer rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2',
                className,
            )}
        >
            {children}
        </button>
    );
}
