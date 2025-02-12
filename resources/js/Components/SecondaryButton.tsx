import { ButtonHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function SecondaryButton({
    type = 'button',
    className = '',
    children,
    ...props
}: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            type={type}
            className={classNames(
                'rounded-md bg-white px-2.5 py-1.5 text-sm text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50',
                'disabled:opacity-25 disabled:hover:bg-white',
                className
            )}
        >
            {children}
        </button>
    );
}
