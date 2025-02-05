import React, {Dispatch, PropsWithChildren, SetStateAction, useEffect, useState} from 'react';
import ReportData from "@/types/report/ReportData";
import { useForm } from '@inertiajs/react';
import {PageProps} from "@/types";
import {Incident} from "@/types/incident/Incident";
import ReportBuildingBlock from "@/Pages/Report/Partials/ReportBuildingBlock";
import ToggleSwitch from "@/Components/ToggleSwitch";
import {isValidEmail} from "@/Filters/isValidEmail";

export interface ReportBuilderProps {
    formData: ReportData;
    setFormData:  Dispatch<SetStateAction<ReportData>>;
}
export interface ReportBuildingBlockProps{
    kee: keyof ReportData;
    formData: ReportData;
    setFormData:  Dispatch<SetStateAction<ReportData>>;
}
interface timelineLengthsInterface {
    stringify: string;
    stringifyPlural: string;
    iters: number;
    iters_sm?: number;
    iters_lg?: number;
}

export default function ReportBuilder({
    formData,
    setFormData,
}: ReportBuilderProps){
    const [hasTimeline, setHasTimeline] = useState(true);
    const [startDateShow, setStartDateShow] = useState(false);
    const [endDateShow, setEndDateShow] = useState(false);
    const timelineLengths = {
        day : {
            stringify: 'Day',
            stringifyPlural: 'Days',
            iters: 1,
        }as timelineLengthsInterface,
        week : {
            stringify: 'Week',
            stringifyPlural: 'Weeks',
            iters: 7,
        }as timelineLengthsInterface,
        month : {
            stringify: 'Month',
            stringifyPlural: 'Months',
            iters_sm: 30,
            iters_lg: 31,
        }as timelineLengthsInterface,
        year : {
            stringify: 'Day',
            stringifyPlural: 'Days',
            iters: 1,
        }as timelineLengthsInterface,
        allTime : {
            stringify: 'All Time',
            stringifyPlural: 'All Time',
            iters: 0,
        }as timelineLengthsInterface,
    } ;
    const lengthItems = Object.keys(timelineLengths) as Array<keyof typeof timelineLengths>;
    const [timelineLength, setTimelineLength] = useState<timelineLengthsInterface>(timelineLengths.day);
    const numIters = Array.from({length:12}, (_, i) => i + 1);
    const [numItersSelected, setNumItersSelected] = useState<number>(1);
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

    const handleTimelineChange = () => {
        setHasTimeline((prev) => !prev);
        if(hasTimeline && (startDateShow || endDateShow)){
            setStartDateShow(false);
            setEndDateShow(false);
        }
    }

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
    <div className="rounded-xl border-2 mx-4">
        <p className="ml-3 mt-3 text-pretty text-m font-light text-gray-500 ">
            Choose the timeline of incidents you want to include in your report:
        </p>
        <div className="flex grid grid-cols-4">

        </div>

    </div>

    </>
);


}
