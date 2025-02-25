import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import LabelledRadioInput from '@/Components/RadioInput/LabelledRadioInput';
import RadioGroup from '@/Components/RadioInput/RadioGroup';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import { ppeValues } from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';

export default function PersonalProtectiveEquipment({ setFormData, errors }: RootCauseAnalysisComponentProps) {
    return (
        <div>
            <InputLabel className="mb-1 text-base text-gray-900">Using PPE</InputLabel>
            <div className="flex justify-evenly">
                {Object.entries(ppeValues).map(([key, label]) => (
                    <>
                        <RadioGroup legend={label}>
                            <InputError message={errors ? errors[key as keyof RootCauseAnalysisData] : ''} />
                            <LabelledRadioInput name={label} onChange={(e) => setFormData(key as keyof RootCauseAnalysisData, e.target.checked)}>
                                Yes
                            </LabelledRadioInput>
                            <LabelledRadioInput name={label} onChange={(e) => setFormData(key as keyof RootCauseAnalysisData, !e.target.checked)}>
                                No
                            </LabelledRadioInput>
                        </RadioGroup>
                    </>
                ))}
            </div>
        </div>
    );
}
