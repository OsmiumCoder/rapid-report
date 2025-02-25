import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes } from 'react';

export default function SecondaryButton({ type = 'button', className = '', children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            type={type}
            className={classNames(
                'rounded-md bg-white px-2.5 py-1.5 text-sm text-gray-900 shadow-xs ring-1 ring-gray-300 ring-inset hover:bg-gray-50',
                'disabled:opacity-25 disabled:hover:bg-white',
                className,
            )}
        >
            {children}
        </button>
    );
}
