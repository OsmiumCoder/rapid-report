import isStage from "@/Pages/Incident/Stages/Stage";
import { ChevronDownIcon } from '@heroicons/react/16/solid'

export default function Stage2(config: isStage): { boolHandle: Function, dataHandle: Function, currentData: {} } {

    return (
        <>
            <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg font-medium text-gray-900">
                Personal Information
            </label>
            <div>
                <label htmlFor="first_name" className="block text-sm/6 font-medium text-gray-900">
                    First Name
                </label>
                <div className="mt-2">
                    <input
                        id="first_name"
                        name="first_name"
                        required
                        value={config.currentData.first_name}
                        onChange={config.dataHandle}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>

            <div>
                <div className="flex items-center justify-between">
                    <label htmlFor="last_name" className="block text-sm/6 font-medium text-gray-900">
                        Last Name
                    </label>
                </div>
                <div className="mt-2">
                    <input
                        id="last_name"
                        name="last_name"
                        required
                        value={config.currentData.last_name}
                        onChange={config.dataHandle}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                <label htmlFor="phone_number" className="block text-sm/6 font-medium text-gray-900">
                    Phone Number
                </label>
                <div className="mt-2">
                    <input
                        id="phone_number"
                        name="phone_number"
                        required
                        value={config.currentData.phone_number}
                        onChange={config.dataHandle}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                <label htmlFor="role" className="block text-sm/6 font-medium text-gray-900">
                    Incident Role
                </label>
                <div className="mt-2 grid grid-cols-1">
                    <select
                        id="role"
                        name="role"
                        defaultValue="Victim"
                        value={config.currentData.role}
                        onChange={config.dataHandle}
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    >
                        <option>Victim</option>
                        <option>Supervisor</option>
                        <option>Witness</option>
                    </select>
                    <ChevronDownIcon
                        aria-hidden="true"
                        className="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                    />
                </div>
                </div>
            </div>
        </>
        
        );
}
