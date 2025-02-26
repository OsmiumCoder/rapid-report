import { InputHTMLAttributes } from 'react';

// TODO: Remove this component in favor of LabeledCheckbox
export default function Checkbox({ className = '', ...props }: InputHTMLAttributes<HTMLInputElement>) {
    return (
        <input
            {...props}
            type="checkbox"
            className={'text-upei-green-500 focus:ring-upei-green-600 rounded-sm border-gray-300 shadow-xs ' + className}
        />
    );
}
