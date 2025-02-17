import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import {
    executionOfWorkValues,
    ppeValues,
} from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import RadioGroup from '@/Components/RadioInput/RadioGroup';
import LabelledRadioInput from '@/Components/RadioInput/LabelledRadioInput';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';
import InputError from '@/Components/InputError';

export default function ExecutionOfWork({ setFormData, errors }: RootCauseAnalysisComponentProps) {
    return (
        <>
            <p className="text-sm text-gray-900 font-medium">Execution of Work – Did You:</p>
            <div className="flex justify-evenly">
                {Object.entries(executionOfWorkValues).map(([key, label], i) => (
                    <>
                        <RadioGroup legend={label}>
                            <LabelledRadioInput
                                name={i.toString()}
                                onChange={(e) =>
                                    setFormData(
                                        key as keyof RootCauseAnalysisData,
                                        e.target.checked
                                    )
                                }
                            >
                                Yes
                            </LabelledRadioInput>
                            <LabelledRadioInput name={i.toString()}>No</LabelledRadioInput>
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
