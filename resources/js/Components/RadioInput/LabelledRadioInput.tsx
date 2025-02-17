import { DetailedHTMLProps, InputHTMLAttributes, PropsWithChildren } from 'react';

export default function LabelledRadioInput({
    children,
    ...props
}: PropsWithChildren<DetailedHTMLProps<InputHTMLAttributes<HTMLInputElement>, HTMLInputElement>>) {
    return (
        <div className="flex items-center">
            <input
                {...props}
                type="radio"
                className="relative size-4 appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white checked:border-upei-green-600 checked:bg-upei-green-500 focus:outline-none focus:ring-2 focus:ring-upei-green-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden [&:not(:checked)]:before:hidden focus:checked:bg-upei-green-500 focus:checked:border-upei-green-500 hover:checked:bg-upei-green-600"
            />
            <label className="ml-3 block text-sm/6">{children}</label>
        </div>
    );
}
