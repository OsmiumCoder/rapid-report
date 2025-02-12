import { SelectProps } from '@headlessui/react';
import { DetailedHTMLProps, PropsWithChildren, SelectHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function SelectInput({
    children,
    className = '',
    ...props
}: PropsWithChildren<
    DetailedHTMLProps<SelectHTMLAttributes<HTMLSelectElement>, HTMLSelectElement>
>) {
    return (
        <select
            {...props}
            className={classNames(
                'col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:ring-0 focus:outline-none focus:outline-upei-green-600 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6 focus-visible:outline-upei-green-600 focus-visible:outline-2 focus-visible:-outline-offset-2',
                className
            )}
        >
            {children}
        </select>
    );
}
