import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes } from 'react';

export default function PrimaryButton({ className = '', children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'rounded-md bg-upei-green-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-upei-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600',
                className,
            )}
        >
            {children}
        </button>
    );
}
