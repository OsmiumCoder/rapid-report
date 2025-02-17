import InputLabel from '@/Components/InputLabel';
import TextInput from '@/Components/TextInput';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import { RootCauseAnalysisComponentProps } from '@/Pages/RootCauseAnalysis/Create';
import validatePhoneInput from '@/Filters/validatePhoneInput';

export default function IndividualsInvolved({
    formData,
    setFormData,
}: RootCauseAnalysisComponentProps) {
    return (
        <>
            <div className="font-medium text-lg ">Individuals Involved</div>
            <div className="flex flex-col w-full">
                {formData.individuals_involved.map(({ name, email, phone }, i) => (
                    <div key={i} className="flex flex-col gap-y-2 border-b border-gray-200 py-2">
                        <p className="font-medium">{`Individual #${i + 1}`}</p>
                        <InputLabel>Name</InputLabel>
                        <TextInput
                            value={name}
                            onChange={(e) => {
                                formData.individuals_involved[i].name = e.target.value;
                                setFormData('individuals_involved', formData.individuals_involved);
                            }}
                        />
                        <InputLabel>Email</InputLabel>
                        <TextInput
                            onChange={(e) => {
                                formData.individuals_involved[i].email = e.target.value;
                                setFormData('individuals_involved', formData.individuals_involved);
                            }}
                            value={email}
                        />
                        <InputLabel>Phone</InputLabel>
                        <TextInput
                            onChange={(e) => {
                                formData.individuals_involved[i].phone = validatePhoneInput(
                                    e.target.value
                                );
                                setFormData('individuals_involved', formData.individuals_involved);
                            }}
                            value={phone}
                        />
                    </div>
                ))}
                <div className="flex justify-between items-center my-2">
                    <PrimaryButton
                        type="button"
                        className="self-end"
                        onClick={() =>
                            setFormData('individuals_involved', [
                                ...formData.individuals_involved,
                                { name: '', email: '', phone: '' },
                            ])
                        }
                    >
                        Add
                    </PrimaryButton>
                    {formData.individuals_involved.length > 1 && (
                        <DangerButton
                            type="button"
                            onClick={() =>
                                setFormData(
                                    'individuals_involved',
                                    formData.individuals_involved.splice(
                                        0,
                                        formData.individuals_involved.length - 1
                                    )
                                )
                            }
                        >
                            Delete
                        </DangerButton>
                    )}
                </div>
            </div>
        </>
    );
}
