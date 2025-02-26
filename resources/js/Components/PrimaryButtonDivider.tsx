import classNames from '@/Filters/classNames';
import { ButtonHTMLAttributes, PropsWithChildren } from 'react';

export default function PrimaryButtonDivider({ children, className = '', ...props }: PropsWithChildren<ButtonHTMLAttributes<HTMLButtonElement>>) {
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
                        'cursor-pointer inline-flex items-center gap-x-1.5 rounded-full bg-upei-green-500 px-3 py-1.5 text-sm font-semibold text-white shadow-xs ring-1 ring-inset ring-upei-green-500 hover:bg-upei-green-600',
                        className
                    )}
                >
                    {children}
                </button>
            </div>
        </div>
    );
}
