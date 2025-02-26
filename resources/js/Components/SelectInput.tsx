import classNames from '@/Filters/classNames';
import { DetailedHTMLProps, PropsWithChildren, SelectHTMLAttributes } from 'react';
import {ChevronDownIcon} from "@heroicons/react/20/solid";

export default function SelectInput({
    children,
    className = '',
    ...props
}: PropsWithChildren<DetailedHTMLProps<SelectHTMLAttributes<HTMLSelectElement>, HTMLSelectElement>>) {
    return (
        <div className="mt-2 grid grid-cols-1">
            <select
                {...props}
                className={classNames(
                    'col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-upei-green-600 sm:text-sm/6',
                    className,
                )}
            >
                {children}
            </select>
            <ChevronDownIcon
                aria-hidden="true"
                className="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
            />
        </div>
    );
}
