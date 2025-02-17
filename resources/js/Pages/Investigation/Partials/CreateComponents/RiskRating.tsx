import { InvestigationComponentProps } from '@/Pages/Investigation/Create';
import { InformationCircleIcon } from '@heroicons/react/24/outline';
import SelectInput from '@/Components/SelectInput';
import RiskRankingModal from '@/Pages/Investigation/Partials/CreateComponents/RiskRankingModal';
import React from 'react';
import InputError from '@/Components/InputError';

export default function RiskRating({ formData, setFormData, errors }: InvestigationComponentProps) {
    const [isModalOpen, setIsModalOpen] = React.useState(false);

    return (
        <>
            <div className="mb-4">
                <label className="flex items-center text-gray-700">
                    Risk Ranking:
                    <InformationCircleIcon
                        onClick={() => setIsModalOpen(true)}
                        className="size-6 ml-2 hover:text-gray-400 hover:cursor-pointer "
                    />
                </label>
                <SelectInput
                    value={formData.risk_rank}
                    onChange={(e) => setFormData('risk_rank', parseInt(e.target.value))}
                    className="p-2 border border-gray-300 rounded-md w-full"
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
