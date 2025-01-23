import {StageProps} from "@/Pages/Incident/Stages/StageWrapper";
import React from "react";

export default function SupervisorStage(
    {
        formData,
        setFormData
    }: StageProps) {

    return(
            <div className="min-w-0 flex-1 text-sm/6 space-y-4">
                <label className="flex justify-center font-bold text-lg text-gray-900">
                    Supervisor
                </label>

            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Supervisor Name
                </label>
                <div className="mt-2">
                    <input
                        value = {formData.supervisor_name}
                        onChange = {(e) => {
                            setFormData((prev) => ({
                                ...prev,
                                supervisor_name: e.target.value
                            }))
                        }}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                <label className="block text-sm/6 font-medium text-gray-900">
                    Supervisor Email
                </label>
                <div className="mt-2">
                    <input
                        type="email"
                        value = {formData.supervisor_email}
                        onChange = {(e) => {
                            setFormData((prev) => ({
                                ...prev,
                                supervisor_email: e.target.value,
                            }))
                        }}
                        placeholder="supervisor@upei.ca"
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div className="mt-2">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Department
                    </label>
                </div>

                <div className="mt-1">
                    <input
                        required
                        value={formData.supervisor_dep ?? ''}
                        onChange={(e) =>
                            setFormData((prev) => ({
                                ...prev,
                                supervisor_dep: e.target.value,
                            }))
                        }
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>


        </div>
    );


}
