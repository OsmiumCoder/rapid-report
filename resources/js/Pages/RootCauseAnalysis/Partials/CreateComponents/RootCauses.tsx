import InputLabel from '@/Components/InputLabel';
import {
    followingProcedures,
    inattention,
    protectiveMethods,
    toolsEquipmentVehicles,
    workExposure,
    workPlaceEnvironment,
} from '@/Pages/RootCauseAnalysis/Partials/checkBoxOptions';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';

export default function RootCauses({ formData, setFormData }: RootCauseAnalysisComponentProps) {
    const toggleTopThreeCauseCheckbox = (value: string, isChecked: boolean) => {
        if (isChecked && formData.root_causes.length === 3) return;

        const updatedList = formData.root_causes.includes(value)
            ? formData.root_causes.filter((item) => item !== value)
            : [...(formData.root_causes ?? []), value];
        setFormData('root_causes', updatedList);
    };

    return (
        <>
            <div>
                <p className="text-gray-900 font-medium text-lg">Root Causes</p>
                <InputLabel>Choose the top 3 options from the following lists:</InputLabel>
            </div>
            <div className="grid grid-cols-2 space-y-5 items-ev">
                <div>
                    <InputLabel className="text-gray-900">Following Procedures</InputLabel>
                    {followingProcedures.map((val) => (
                        <LabeledCheckbox
                            disabled={
                                formData.root_causes &&
                                formData.root_causes.length >= 3 &&
                                !formData.root_causes.includes(val)
                            }
                            key={val}
                            label={val}
                            onChange={(e) => toggleTopThreeCauseCheckbox(val, e.target.checked)}
                        />
                    ))}
                </div>
                <div>
                    <InputLabel className="text-gray-900">Tools, equipment and vehicles</InputLabel>
                    {toolsEquipmentVehicles.map((val) => (
                        <LabeledCheckbox
                            disabled={
                                formData.root_causes.length >= 3 &&
                                !formData.root_causes.includes(val)
                            }
                            key={val}
                            label={val}
                            onChange={(e) => toggleTopThreeCauseCheckbox(val, e.target.checked)}
                        />
                    ))}
                </div>
                <div>
                    <InputLabel className="text-gray-900">
                        Inattention/lack of awareness/training
                    </InputLabel>
                    {inattention.map((val) => (
                        <LabeledCheckbox
                            disabled={
                                formData.root_causes.length >= 3 &&
                                !formData.root_causes.includes(val)
                            }
                            key={val}
                            label={val}
                            onChange={(e) => toggleTopThreeCauseCheckbox(val, e.target.checked)}
                        />
                    ))}
                </div>
                <div>
                    <InputLabel className="text-gray-900">
                        Use of protective methods & systems
                    </InputLabel>
                    {protectiveMethods.map((val) => (
                        <LabeledCheckbox
                            disabled={
                                formData.root_causes.length >= 3 &&
                                !formData.root_causes.includes(val)
                            }
                            key={val}
                            label={val}
                            onChange={(e) => toggleTopThreeCauseCheckbox(val, e.target.checked)}
                        />
                    ))}
                </div>
                <div>
                    <InputLabel className="text-gray-900">Work exposure to:</InputLabel>
                    {workExposure.map((val) => (
                        <LabeledCheckbox
                            disabled={
                                formData.root_causes.length >= 3 &&
                                !formData.root_causes.includes(val)
                            }
                            key={val}
                            label={val}
                            onChange={(e) => toggleTopThreeCauseCheckbox(val, e.target.checked)}
                        />
                    ))}
                </div>
                <div>
                    <InputLabel className="text-gray-900">Work Place/environment/layout</InputLabel>
                    {workPlaceEnvironment.map((val) => (
                        <LabeledCheckbox
                            disabled={
                                formData.root_causes.length >= 3 &&
                                !formData.root_causes.includes(val)
                            }
                            key={val}
                            label={val}
                            onChange={(e) => toggleTopThreeCauseCheckbox(val, e.target.checked)}
                        />
                    ))}
                </div>
            </div>
        </>
    );
}
