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
                'rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm,' +
                    'hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600',
                props.disabled ? 'opacity-25' : '',
                className
            )}
        >
            {children}
        </button>
    );
}
