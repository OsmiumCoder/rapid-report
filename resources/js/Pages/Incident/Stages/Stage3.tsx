
import { ChevronDownIcon } from '@heroicons/react/16/solid'
import React, { useState, useEffect } from 'react';

export default function Stage3(config: isStage): { boolHandle: Function, dataHandle: Function, currentData: {} } {
    const [currentCatagory, setCurrentCatagory] = useState("Safety");
    const catagories = ["Safety", "Security", "Enviromental"];
    const safety_catagories = ["Injury", "Illness", "Exposure", "Animal bite/sting/scratch", "Needle/sharp/puncture/cut", "Slip/Trip/fall", "Burn/Shock", "Sexual Harrasment", "Personal Harrasment", "Discrimination", "Near Miss/Hazard","Other"];
    const security_catagories = ["Lab Biosecurity incident/threat", "Theft/Assault", "Bomb threat", "Violent Threat/Harrasment", "Property damage/Equipment Loss", "Suspicous Activity", "Near Miss/Hazard", "Other"];
    const enviromental_catagories = ["Spill", "Hazardous Materials", "Fire", "Infectious Materials", "Air/Water pollution", "Near Miss/Hazard", "Other"];
    useEffect(() => {
        let optionList = document.getElementById('incident_type').options;
        let i = optionList.length;
        while (i--) {
            optionList.remove(i - 1);
        }
        switch (currentCatagory) {
            case "Safety":
                safety_catagories.forEach(cat => optionList.add(new Option(cat)));
                break;
            case "Security":
                security_catagories.forEach(cat => optionList.add(new Option(cat)));
                break;
            case "Enviromental":
                enviromental_catagories.forEach(cat => optionList.add(new Option(cat)));
                break;
        }
    });
    
    const handleCatChange = (e) => {
        const val = e.target.value;
        setCurrentCatagory(val);
        let current = []
        let optionList = document.getElementById('incident_type').options;
        let i = optionList.length;
        while (i--) {
            optionList.remove(i - 1);
        }
        

    }

    return (
        <>
            <div className="min-w-0 flex-1 text-sm/6">
                <label className="flex justify-center font-bold text-lg font-medium text-gray-900">
               Context Incident Information
                </label>

                <div>
                    <div className= "flex">
                    <div className="min-w-0 flex-1 text-sm/6">
                            <label htmlFor="work_related" className="font-medium text-gray-900">
                            Work Related
                        </label>
                            <p id="work_related-description" className="text-xs text-gray-500">
                            Was the Incident Work related?
                        </p>
                    </div>
                    <div className="flex h-6 shrink-0 items-center">
                        <div className="group grid size-4 grid-cols-1">
                            <input
                                    id="work_related"
                                    name="work_related"
                                type="checkbox"
                                    aria-describedby="work_related-description"
                                    checked={config.currentData.work_related}
                                    onChange={config.boolHandle}
                                className="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                            />
                            <svg
                                fill="none"
                                viewBox="0 0 14 14"
                                className="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-[:disabled]:stroke-gray-950/25"
                            >
                                <path
                                    d="M3 8L6 11L11 3.5"
                                    strokeWidth={2}
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    className="opacity-0 group-has-[:checked]:opacity-100"
                                />
                                <path
                                    d="M3 7H11"
                                    strokeWidth={2}
                                    strokeLinecap="round"
                                    strokeLinejoin="round"
                                    className="opacity-0 group-has-[:indeterminate]:opacity-100"
                                />
                            </svg>
                        </div>
                        </div>
                        </div>
                <label htmlFor="location" className="block text-sm/6 font-medium text-gray-900">
                    Location
                    </label>
                    <p id="location-description" className="text-xs text-gray-500">
                        Enter the building or description of area where the incident occurred.
                    </p>
                <div className="mt-2">
                    <input
                            id="location"
                            name="location"

                            aria-describedby="location-description"
                        required
                        value={config.currentData.location}
                        onChange={config.dataHandle}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>

            <div>
                <div className="flex items-center justify-between">
                        <label htmlFor="room_number" className="block text-sm/6 font-medium text-gray-900">
                        Room Number
                    </label>
                    </div>
                    <p id="room_number-description" className="text-xs text-gray-500">
                        If Applicable.
                        </p>
                    
                <div className="mt-2">
                    <input
                            id="room_number"
                            name="room_number"
                        required
                            value={config.currentData.room_number}
                        onChange={config.dataHandle}
                        className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    />
                </div>
            </div>
            <div>
                    <label htmlFor="incident_catagory" className="block text-sm/6 font-medium text-gray-900">
                    Incident Catagory
                </label>
                <div className="mt-2 grid grid-cols-1">
                        <select
                            id="incident_catagory"
                            name="incident_catagory"
                            defaultValue="Safety"
                            value={currentCatagory}
                            onChange={e => { config.dataHandle(e); handleCatChange(e);  }}
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                        >
                            <option>Safety</option>
                            <option>Security</option>
                            <option>Enviromental</option>
                           
                    </select>
                    
                </div>
                </div>
                <div>
                    <label htmlFor="incident_type" className="block text-sm/6 font-medium text-gray-900">
                    Incident Type
                </label>
                <div className="mt-2 grid grid-cols-1">
                    <select
                            id="incident_type"
                            name="incident_type"
                            defaultValue="Injury"
                            value={config.currentData.incident_type}
                        onChange={config.dataHandle}
                        className="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pl-3 pr-8 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                    >
                    </select>
                    
                </div>
                </div>
                {config.currentData.incident_type == "Other" && (
                    <div>
                        <div className="flex items-center justify-between">
                            <label htmlFor="other_des" className="block text-sm/6 font-medium text-gray-900">
                                Please breifly Describe:
                            </label>
                        </div>
                        <div className="mt-2">
                            <input
                                id="other_des"
                                name="other_des"
                                required
                                value={config.currentData.other_des}
                                onChange={config.dataHandle}
                                className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            />
                        </div>
                    </div>
                    )}
            </div>
        </>
       
    );
    
}
