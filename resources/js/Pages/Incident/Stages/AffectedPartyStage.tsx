import isStage, { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import { ChevronDownIcon } from '@heroicons/react/16/solid';
import IncidentData from '@/types/IncidentData';

export default function AffectedPartyStage({
    formData,
    setFormData,
}: StageProps) {
    const roles = [
        {
            value: 1,
            name: 'Employee',
        },
        {
            value: 2,
            name: 'Student',
        },
        {
            value: 3,
            name: 'Visitor',
        },
        {
            value: 4,
            name: 'Contractor',
        },
        {
            value: 5,
            name: 'Contractor',
        },
    ];
    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Affected Party Information
            </label>
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    First Name
                </label>
                <div className="mt-2">
                    <input
                        required
                        value={formData.first_name ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                first_name: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>

            <div>
                <div className="flex items-center justify-between">
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Last Name
                    </label>
                </div>
                <div className="mt-2">
                    <input
                        required
                        value={formData.last_name ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                last_name: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Phone Number
                </label>
                <div className="mt-2">
                    <input
                        required
                        value={formData.phone ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                phone: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Incident Role
                </label>
                <div className="mt-2 grid grid-cols-1">
                    <select
                        value={formData.role ?? roles[0].name}
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        onChange={() => {}}
                    >
                        {roles.map(({ name, value }, index) => (
                            <option
                                key={index}
                                onClick={(e) =>
                                    setFormData((prev) => ({
                                        ...prev,
                                        role: value,
                                    }))
                                }
                            >
                                {name}
                            </option>
                        ))}
                    </select>
                </div>
            </div>
        </div>
    );
}
