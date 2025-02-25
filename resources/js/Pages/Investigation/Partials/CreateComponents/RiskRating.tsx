import InputError from '@/Components/InputError';
import SelectInput from '@/Components/SelectInput';
import { InvestigationComponentProps } from '@/Pages/Investigation/Create';
import RiskRankingModal from '@/Pages/Investigation/Partials/CreateComponents/RiskRankingModal';
import { InformationCircleIcon } from '@heroicons/react/24/outline';
import React from 'react';

export default function RiskRating({ formData, setFormData, errors }: InvestigationComponentProps) {
    const [isModalOpen, setIsModalOpen] = React.useState(false);

    return (
        <>
            <div className="mb-4">
                <label className="flex items-center text-gray-700">
                    Risk Ranking:
                    <InformationCircleIcon onClick={() => setIsModalOpen(true)} className="ml-2 size-6 hover:cursor-pointer hover:text-gray-400" />
                </label>
                <SelectInput
                    value={formData.risk_rank}
                    onChange={(e) => setFormData('risk_rank', parseInt(e.target.value))}
                    className="w-full rounded-md border border-gray-300 p-2"
                >
                    {Array(9)
                        .fill(0)
                        .map((_, i) => (
                            <option key={i} value={i + 1}>
                                {i + 1}
                            </option>
                        ))}
                </SelectInput>
            </div>
            <InputError message={errors?.risk_rank} />
            <RiskRankingModal isOpen={isModalOpen} setIsOpen={setIsModalOpen} />
        </>
    );
}
