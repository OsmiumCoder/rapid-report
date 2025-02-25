import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import LabelledRadioInput from '@/Components/RadioInput/LabelledRadioInput';
import RadioGroup from '@/Components/RadioInput/RadioGroup';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import { executionOfWorkValues } from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import { RootCauseAnalysisData } from '@/types/rootCauseAnalysis/RootCauseAnalysisData';

export default function ExecutionOfWork({ setFormData, errors }: RootCauseAnalysisComponentProps) {
    return (
        <div>
            <InputLabel className="mb-1 text-base text-gray-900">Execution of Work</InputLabel>

            <div className="flex justify-evenly">
                {Object.entries(executionOfWorkValues).map(([key, label], i) => (
                    <>
                        <RadioGroup legend={label}>
                            <InputError message={errors ? errors[key as keyof RootCauseAnalysisData] : ''} className="max-w-32" />
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
