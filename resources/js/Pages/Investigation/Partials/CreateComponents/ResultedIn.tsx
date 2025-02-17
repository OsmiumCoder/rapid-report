import { InvestigationComponentProps } from '@/Pages/Investigation/Create';
import { resultedIn } from '@/Pages/Investigation/Partials/createDropdownValues';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import React from 'react';

export default function ResultedIn({
    formData,
    setFormData,
    errors,
    toggleCheckbox,
}: InvestigationComponentProps) {
    return (
        <fieldset className="mb-4">
            <legend className="font-semibold text-gray-700 mb-2">Incident Resulted In:</legend>
            <div className="grid grid-cols-2">
                {resultedIn.map((result) => (
                    <LabeledCheckbox
                        key={result}
                        label={result}
                        value={result}
                        checked={formData.resulted_in.includes(result)}
                        onChange={() => toggleCheckbox('resulted_in', result)}
                        className="mr-2"
                    />
                ))}
            </div>
        </fieldset>
    );
}
