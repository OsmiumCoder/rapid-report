import React, { useEffect, useState } from 'react';
import {ReportBuildingBlockProps} from "@/Pages/Report/Partials/ReportBuilder"
import ReportData from "@/types/report/ReportData";

export default function ReportBuildingBlock({kee,formData, setFormData}:ReportBuildingBlockProps){
    useEffect(() => {
        console.log(kee);
    }, []);
    const pretty_labels = {
        closed_at: "Closed At",
        created_at: "Created At",
        deleted_at: "Deleted At",
        description: "Description",
        descriptor: "Descriptor",
        first_aid_description: "First Aid Description",
        happened_at: "Happened At",
        incident_type: "Incident Type",
        injury_description: "Injury Description",
        location: "Location",
        room_number: "Room Number",
        updated_at: "Updated At",
        work_related: "Work Related",
        workers_comp_submitted: "Workers Comp Submitted"
    };
    return(
        <>
            <div className="flex grid-cols-2 rounded-xl border-2 m-3 p-2">
                <div className="mr-3 text-pretty font-medium text-gray-500">

                    {pretty_labels[kee]}
                </div>
                <div className="flex h-6 shrink-0 items-center">
                    <div className="group grid size-4 grid-cols-1">
                        <input
                            checked={formData[kee]}
                            type="checkbox"
                            aria-describedby="comments-description"
                            className="col-start-1 row-start-1 appearance-none rounded border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto"
                            onChange={(e) =>{
                                setFormData((prev) => ({
                                    ...prev,
                                    [kee]: e.target.checked
                                }))
                            }}
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
        </>
    );
}
