import isStage, { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import { ChevronDownIcon } from '@heroicons/react/16/solid';
import IncidentData from '@/types/IncidentData';
import { roles } from '@/Pages/Incident/Stages/IncidentDropDownValues';

export default function AffectedPartyStage({
    formData,
    setFormData,
}: StageProps) {
    function validatePhoneInput(value: string) {
        value = value.replace(/[^0-9-]/g, '');

        if (value.length > 3 && value[3] !== '-') {
            value = value.slice(0, 3) + '-' + value.slice(3);
        }
        if (value.length > 7 && value[7] !== '-') {
            value = value.slice(0, 7) + '-' + value.slice(7);
        }
        return value.slice(0, 12); // Enforce max length
    }

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
                        type="tel"
                        placeholder="123-456-7890"
                        value={formData.phone ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                phone: validatePhoneInput(e.target.value),
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Email
                </label>
                <div className="mt-2">
                    <input
                        required
                        type="email"
                        placeholder="name@example.com"
                        value={formData.email ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                email: e.target.value,
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
                        value={
                            roles.find(({ value }) => value === formData?.role)
                                ?.name ?? roles[0].name
                        }
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                role: roles.find(
                                    ({ name }) => name === e.target.value
                                )?.value,
                            }))
                        }
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    >
                        {roles.map(({ name }, index) => (
                            <option key={index}>{name}</option>
                        ))}
                    </select>
                </div>
            </div>
        </div>
    );
}
