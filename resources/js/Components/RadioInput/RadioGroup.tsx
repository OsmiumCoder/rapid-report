import { PropsWithChildren } from 'react';

export default function RadioGroup({
    legend,
    subLegend,
    children,
}: PropsWithChildren<{
    legend?: string;
    subLegend?: string;
}>) {
    return (
        <fieldset>
            {legend && <legend className="text-sm/6 font-semibold text-gray-900">{legend}</legend>}
            {subLegend && <p className="mt-1 text-sm/6 text-gray-600">{subLegend}</p>}
            <div className="mt-2 ml-6 space-y-6">{children}</div>
        </fieldset>
    );
}
