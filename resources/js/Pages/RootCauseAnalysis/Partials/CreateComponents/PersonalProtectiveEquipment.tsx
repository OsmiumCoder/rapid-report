import RadioGroup from '@/Components/RadioInput/RadioGroup';
import LabelledRadioInput from '@/Components/RadioInput/LabelledRadioInput';
import InputError from '@/Components/InputError';
import { ppeValues } from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import InputLabel from '@/Components/InputLabel';

export default function PersonalProtectiveEquipment({
    setFormData,
    errors,
}: RootCauseAnalysisComponentProps) {
    return (
        <div>
            <InputLabel className="text-gray-900 text-base mb-1">Using PPE</InputLabel>
            <div className="flex justify-evenly">
                {Object.entries(ppeValues).map(([key, label], i) => (
                    <>
                        <RadioGroup legend={label}>
                            <InputError
                                message={errors ? errors[key as keyof RootCauseAnalysisData] : ''}
                            />
                            <LabelledRadioInput
                                name={label}
                                onChange={(e) =>
                                    setFormData(
                                        key as keyof RootCauseAnalysisData,
                                        e.target.checked
                                    )
                                }
                            >
                                Yes
                            </LabelledRadioInput>
                            <LabelledRadioInput
                                name={label}
                                onChange={(e) =>
                                    setFormData(
                                        key as keyof RootCauseAnalysisData,
                                        !e.target.checked
                                    )
                                }
                            >
                                No
                            </LabelledRadioInput>
                        </RadioGroup>
                    </>
                ))}
            </div>
        </div>
    );
}
