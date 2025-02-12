import { ButtonHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function PrimaryButton({
    className = '',
    children,
    ...props
}: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'rounded-md bg-upei-green-500 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm',
                'hover:bg-upei-green-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600',
                'disabled:opacity-25 disabled:hover:bg-upei-green-500',
                className
            )}
        >
            {children}
        </button>
    );
}
