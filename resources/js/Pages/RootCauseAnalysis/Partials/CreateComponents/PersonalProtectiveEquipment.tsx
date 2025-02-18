import RadioGroup from '@/Components/RadioInput/RadioGroup';
import LabelledRadioInput from '@/Components/RadioInput/LabelledRadioInput';
import InputError from '@/Components/InputError';
import { ppeValues } from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';

export default function PersonalProtectiveEquipment({
    setFormData,
    errors,
}: RootCauseAnalysisComponentProps) {
    return (
        <>
            <p className="text-sm text-gray-900 font-medium">Using PPE – Was It:</p>
            <div className="flex justify-evenly">
                {Object.entries(ppeValues).map(([key, label], i) => (
                    <>
                        <RadioGroup legend={label}>
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
                        <InputError
                            message={
                                errors ? errors[key as keyof RootCauseAnalysisData] : undefined
                            }
                            className="mt-2"
                        />
                    </>
                ))}
            </div>
        </>
    );
}
