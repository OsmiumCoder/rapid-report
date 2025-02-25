import InputError from '@/Components/InputError';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import { InvestigationComponentProps } from '@/Pages/Investigation/Create';
import { resultedIn } from '@/Pages/Investigation/Partials/createDropdownValues';

export default function ResultedIn({ formData, errors, toggleCheckbox }: InvestigationComponentProps) {
    return (
        <fieldset className="mb-4">
            <legend className="mb-2 font-semibold text-gray-700">Incident Resulted In:</legend>
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
                <InputError className="mt-1" message={errors.resulted_in} />
            </div>
        </fieldset>
    );
}
