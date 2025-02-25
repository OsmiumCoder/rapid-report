import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes, PropsWithChildren } from 'react';

export default function PrimaryButtonDivider({ children, ...props }: PropsWithChildren<ButtonHTMLAttributes<HTMLButtonElement>>) {
    return (
        <div className="relative">
            <div aria-hidden="true" className="absolute inset-0 flex items-center">
                <div className="w-full border-t border-gray-300" />
            </div>
            <div className="relative flex justify-center">
                <button
                    type="button"
                    {...props}
                    className={classNames(
                        'inline-flex items-center gap-x-1.5 rounded-full px-3 py-1.5 text-sm',
                        'bg-upei-green-500 font-semibold text-white shadow-sm',
                        'hover:bg-upei-green-600 focus-visible:outline-upei-green-600 focus-visible:outline-2 focus-visible:outline-offset-2',
                        'disabled:hover:bg-upei-green-500 disabled:opacity-25',
                    )}
                >
                    {children}
                </button>
            </div>
        </div>
    );
}
