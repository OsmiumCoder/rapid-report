import classNames from '@/Filters/classNames';
import { InputHTMLAttributes } from 'react';

interface LabeledCheckBoxProps extends InputHTMLAttributes<HTMLInputElement> {
    label: string;
}

export default function LabeledCheckbox({ label, ...props }: LabeledCheckBoxProps) {
    return (
        <div className="flex items-center gap-3">
            <div className="flex h-5 shrink-0 items-center">
                <div className="group ml-2 grid size-4 grid-cols-1">
                    <input
                        {...props}
                        type="checkbox"
                        className="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-upei-green-600 checked:bg-upei-green-600 indeterminate:border-upei-green-600 indeterminate:bg-upei-green-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-green-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                    />

                    <svg
                        fill="none"
                        viewBox="0 0 14 14"
                        className="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                    >
                        <path
                            d="M3 8L6 11L11 3.5"
                            strokeWidth={2}
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            className="opacity-0 group-has-[:checked]:opacity-100"
                        />
                        <path
                            d="M3 7H11"
                            strokeWidth={2}
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            className="opacity-0 group-has-[:indeterminate]:opacity-100"
                        />
                    </svg>
                </div>
            </div>

            <label className={classNames('text-base text-gray-600 sm:text-sm', props.disabled ? 'opacity-50' : '')}>{label}</label>
        </div>
    );
}
