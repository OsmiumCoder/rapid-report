import { InputHTMLAttributes } from 'react';

export default function Checkbox({ className = '', ...props }: InputHTMLAttributes<HTMLInputElement>) {
    return (
        <input
            {...props}
            type="checkbox"
            className={'rounded border-gray-300 text-upei-green-600 shadow-xs focus:ring-upei-green-500 ' + className}
        />
    );
}
