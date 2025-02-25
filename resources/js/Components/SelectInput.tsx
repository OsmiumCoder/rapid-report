import classNames from '@/Filters/classNames';
import { DetailedHTMLProps, PropsWithChildren, SelectHTMLAttributes } from 'react';

export default function SelectInput({
    children,
    className = '',
    ...props
}: PropsWithChildren<DetailedHTMLProps<SelectHTMLAttributes<HTMLSelectElement>, HTMLSelectElement>>) {
    return (
        <select
            {...props}
            className={classNames(
                'focus:outline-upei-green-600 focus-visible:outline-upei-green-600 col-start-1 row-start-1 appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:ring-0 focus:outline-2 focus:-outline-offset-2 focus:outline-hidden focus-visible:outline-2 focus-visible:-outline-offset-2 sm:text-sm/6',
                className,
            )}
        >
            {children}
        </select>
    );
}
