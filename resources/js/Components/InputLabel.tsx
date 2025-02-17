import { LabelHTMLAttributes } from 'react';
import classNames from '@/Filters/classNames';

export default function InputLabel({
    value,
    className = '',
    children,
    ...props
}: LabelHTMLAttributes<HTMLLabelElement> & { value?: string }) {
    return (
        <label
            {...props}
            className={classNames(`block text-sm font-medium text-gray-700`, className)}
        >
            {value ? value : children}
        </label>
    );
}
