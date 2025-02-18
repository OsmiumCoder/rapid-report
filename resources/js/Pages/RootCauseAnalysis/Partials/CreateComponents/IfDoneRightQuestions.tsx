import InputLabel from '@/Components/InputLabel';
import {
    attentionToWorkValues,
    communicationValues,
    peoplesPositionsValues,
    workingConditions,
} from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import InputError from '@/Components/InputError';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';

export default function IfDoneRightQuestions({
    formData,
    setFormData,
    errors,
}: RootCauseAnalysisComponentProps) {
    const toggleCheckbox = (category: keyof typeof formData, value: string) => {
        const updatedList = (formData[category] as string[]).includes(value)
            ? (formData[category] as string[]).filter((item) => item !== value)
            : [...(formData[category] as string[]), value];
        setFormData(category, updatedList);
    };

    return (
        <>
            <InputLabel>
                <p className="text-gray-900 text-base">People’s Positions</p>
                <div>
                    If this had been done right, it would have prevented the incident (check all
                    that apply)
                </div>
            </InputLabel>
            <div className="flex justify-between mx-4">
                {peoplesPositionsValues.map((val) => (
                    <LabeledCheckbox
                        key={val}
                        label={val}
                        onChange={() => toggleCheckbox('peoples_position', val)}
                    />
                ))}
            </div>
            <InputError message={errors?.peoples_position} className="mt-2" />

            <InputLabel>
                <>
                    <p className="text-gray-900 text-base">Attention To Work</p>
                    <div>
                        If this had been done right, it would’ve prevented the incident (check all
                        that apply)
                    </div>
                </>
            </InputLabel>
            <div className="flex justify-between mx-6">
                {attentionToWorkValues.map((val) => (
                    <LabeledCheckbox
                        key={val}
                        label={val}
                        onChange={() => toggleCheckbox('attention_to_work', val)}
                    />
                ))}
            </div>
            <InputError message={errors?.attention_to_work} className="mt-2" />

            <InputLabel>
                <>
                    <p className="text-gray-900 text-base">Communication</p>
                    <div>
                        If this had been done right, it would have prevented the incident (check all
                        that apply)
                    </div>
                </>
            </InputLabel>
            <div className="flex justify-between mx-6">
                {communicationValues.map((val) => (
                    <LabeledCheckbox
                        key={val}
                        label={val}
                        onChange={() => toggleCheckbox('communication', val)}
                    />
                ))}

                <InputError message={errors?.communication} className="mt-2" />
            </div>

            <InputLabel>
                <>
                    <p className="text-gray-900 text-base">Working Conditions</p>
                    <div>
                        If this had been done right, it would’ve prevented the incident (check all
                        that apply)
                    </div>
                </>
            </InputLabel>
            <div className="flex justify-between mx-6">
                {workingConditions.map((val) => (
                    <LabeledCheckbox
                        key={val}
                        label={val}
                        onChange={() => toggleCheckbox('working_conditions', val)}
                    />
                ))}
                <InputError message={errors?.working_conditions} className="mt-2" />
            </div>
        </>
    );
}
