import { DetailedHTMLProps, TextareaHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function TextArea({
    className = '',
    ...props
}: DetailedHTMLProps<TextareaHTMLAttributes<HTMLTextAreaElement>, HTMLTextAreaElement>) {
    return (
        <textarea
            {...props}
            className={classNames(
                'block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300',
                'placeholder:text-gray-400 focus:outline-none focus:ring-0 focus:shadow-none focus-visible:ring-0 focus-visible:ring-offset-0',
                'focus:border-upei-green-600 focus:ring-upei-green-600 sm:text-sm/6',
                className
            )}
        />
    );
}
