import React, {Dispatch, PropsWithChildren, SetStateAction, useEffect, useState} from 'react';
import ReportData from "@/types/report/ReportData";
import { useForm } from '@inertiajs/react';
import {PageProps} from "@/types";
import {Incident} from "@/types/incident/Incident";
import ReportBuildingBlock from "@/Pages/Report/Partials/ReportBuildingBlock";

export interface ReportBuilderProps {
    formData: ReportData;
    setFormData:  Dispatch<SetStateAction<ReportData>>;
}
export interface ReportBuildingBlockProps{
    kee: keyof ReportData;
    formData: ReportData;
    setFormData:  Dispatch<SetStateAction<ReportData>>;
}

export default function ReportBuilder({
    formData,
    setFormData,
}: ReportBuilderProps){
    const formItems = Object.keys(formData) as Array<keyof ReportData>;
    const formBlocks = formItems.map((key) =>
        <li key={key}>
        <ReportBuildingBlock
            kee={key}
            formData={formData}
            setFormData={setFormData}
        />
        </li>
    )
    return(<>
    <p className="ml-8 mt-8 text-pretty text-lg font-medium text-gray-500 sm:text-xl/8">
        Build your report:
    </p>

    <div className="rounded-xl border-2 mx-4">
        <p className="ml-3 mt-3 text-pretty text-m font-light text-gray-500 ">
            Choose the categories you want to include in your report:
        </p>
        <ul className="flex flex-wrap items-center justify-center text-gray-900 dark:text-white">
            {formBlocks}
        </ul>
    </div>
    </>
);


}
