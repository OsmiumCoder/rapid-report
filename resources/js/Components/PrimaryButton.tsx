import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes } from 'react';

export default function PrimaryButton({ className = '', children, ...props }: ButtonHTMLAttributes<HTMLButtonElement>) {
    return (
        <button
            {...props}
            className={classNames(
                'bg-upei-green-600 hover:bg-upei-green-500 focus-visible:outline-upei-green-600 cursor-pointer rounded-md px-3 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2',
                className,
            )}
        >
            {children}
        </button>
    );
}
