import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes } from 'react';

export default function SecondaryButton({ type = 'button', className = '', children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            type={type}
            className={classNames(
                'rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50',
                className,
            )}
        >
            {children}
        </button>
    );
}
