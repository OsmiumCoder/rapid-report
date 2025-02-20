import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import {
    executionOfWorkValues,
    ppeValues,
} from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import RadioGroup from '@/Components/RadioInput/RadioGroup';
import LabelledRadioInput from '@/Components/RadioInput/LabelledRadioInput';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';

export default function ExecutionOfWork({ setFormData, errors }: RootCauseAnalysisComponentProps) {
    return (
        <div>
            <InputLabel className="text-gray-900 text-base mb-1">Execution of Work</InputLabel>

            <div className="flex justify-evenly">
                {Object.entries(executionOfWorkValues).map(([key, label], i) => (
                    <>
                        <RadioGroup legend={label}>
                            <InputError
                                message={errors ? errors[key as keyof RootCauseAnalysisData] : ''}
                                className="max-w-32"
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
