import { InputHTMLAttributes } from 'react';

export default function Checkbox({ className = '', ...props }: InputHTMLAttributes<HTMLInputElement>) {
    return (
        <input
            {...props}
            type="checkbox"
            className={'text-upei-green-600 focus:ring-upei-green-500 rounded border-gray-300 shadow-xs ' + className}
        />
    );
}
