import React, {Dispatch, SetStateAction, useState} from 'react';
import ReportData from "@/types/report/ReportData";
import ReportBuildingBlock from "@/Pages/Report/Partials/ReportBuildingBlock";
import DatePicker from "@/Components/DatePicker";
import dayjs, {Dayjs, ManipulateType} from "dayjs";
import SecondaryButton from "@/Components/SecondaryButton";
import PrimaryButton from "@/Components/PrimaryButton";

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
    unit: ManipulateType;
}
interface timelineInterface {
    startDate: Dayjs;
    endDate: Dayjs;
}
interface relativeInterface {
    unit:timelineLengthsInterface
    iter:number
}
type timeLengthsCollection = {
    [key: string]: timelineLengthsInterface;
};

export default function ReportBuilder({
    formData,
    setFormData,
}: ReportBuilderProps){
    const currentDate = dayjs(new Date())
    const [timeline, setTimeline] = useState<timelineInterface>({
        startDate: currentDate.subtract(1,'day'),
        endDate: currentDate
})
    const setRelativeTimeline = (iter:number, unit:ManipulateType) => {
        if(unit != 'millisecond') {
            setTimeline(() => ({
                startDate: currentDate.subtract(iter, unit),
                endDate: currentDate
            }));
        }else{
            setTimeline(() => ({
                startDate: dayjs(0),
                endDate: currentDate
            }));
        }

    }
    const setConTimeline = (date : Dayjs, isStart : boolean ) => {
        if(isStart){
            if(date.isAfter(timeline.endDate)||date.isSame(timeline.endDate)){
                setTimeline({
                    endDate: date.add(1,'day'),
                    startDate: date
                })
            }else{
                setTimeline((prev) => ({
                    ...prev,
                    startDate: date,
                }))
            }

        }else{
            if(date.isBefore(timeline.startDate)||date.isSame(timeline.endDate)){
                setTimeline({
                    endDate: date,
                    startDate: date.subtract(1,'day')
                })
            }else{
                setTimeline((prev) => ({
                    ...prev,
                    endDate: date,
                }))
            }
        }
    }
    const exportTypes = [
        {
            action: route('report.downloadFileCSV', 'report_'+ dayjs().format('YYYY-MM-DDTHH:mm:ssZ[Z]') ),
            name:'CSV'
        },
    ]


    const timelineLengths: timeLengthsCollection = {
        day : {
            stringify: 'Day',
            stringifyPlural: 'Days',
            unit: "day",
        },
        week : {
            stringify: 'Week',
            stringifyPlural: 'Weeks',
            unit: "week",
        },
        month : {
            stringify: 'Month',
            stringifyPlural: 'Months',
            unit: "month",
        },
        year : {
            stringify: 'Year',
            stringifyPlural: 'Years',
            unit:"year",
        },
        alltime : {
            stringify: 'All Time',
            stringifyPlural: 'All Time',
            unit:"millisecond"
        }
    } ;
    const lengthItems = Object.keys(timelineLengths) as Array<keyof typeof timelineLengths>;
    const [timelineLength, setTimelineLength] = useState<relativeInterface>({
        unit: timelineLengths.day,
        iter: 1
    });
    const numIters = Array.from({length:12}, (_, i) => i + 1);
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

    <div className="rounded-xl border-2 mx-4 mb-4">
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
        <div className="flex flex-wrap justify-center items-center gap-5 my-4">
            <select
                value={timelineLength.iter}
                onChange={(e) => {
                    setTimelineLength((prev) => ({
                        ...prev,
                        iter: +e.target.value
                    }))
                    setRelativeTimeline( +e.target.value, timelineLength.unit.unit)
                }}
                className="flex rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            >

                {numIters.map((i) => (
                    <option key={i}>{i}</option>
                ))}
            </select>
            <select
                value={(timelineLength.iter>1)?(timelineLength.unit.stringifyPlural):(timelineLength.unit.stringify)}
                onChange={(e) =>{
                    setTimelineLength((prev) => ({
                        ...prev,
                        unit: timelineLengths[(e.target.value.slice(-1)=='s')?(e.target.value.toLowerCase().slice(0, -1)):(e.target.value.toLowerCase().replace(/\s/g, ""))],
                    }))
                    setRelativeTimeline(timelineLength.iter, timelineLengths[(e.target.value.slice(-1)=='s')?(e.target.value.toLowerCase().slice(0, -1)):(e.target.value.toLowerCase().replace(/\s/g, ""))].unit)

            }}
                className="flex rounded-md bg-white py-1.5 pl-3 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
            >

                {(lengthItems.map((index,value) => (
                    (timelineLength.iter>1)?(
                        <option key={value}>{timelineLengths[index].stringifyPlural}</option>
                    ):(
                        <option key={value}>{timelineLengths[index].stringify}</option>
                    )
                )))}
            </select>
        </div>
        <div className="relative">
            <div aria-hidden="true" className="absolute inset-0 flex items-center">
                <div className="w-full mx-5 border-t border-gray-300" />
            </div>
            <div className="relative flex justify-center">
                <span className="bg-gray-100  px-2 text-sm text-gray-500">OR</span>
            </div>
        </div>
        <div className="flex flex-wrap justify-center items-center gap-5 my-4">
            <div className="">
                <DatePicker
                value={timeline.startDate.format('YYYY-MM-DD')}
                onChange={(e) =>{
                    setConTimeline(dayjs(e.target.value),true);
                }}
                />

            </div>
            <div>
                <DatePicker
                    value={timeline.endDate.format('YYYY-MM-DD')}
                    onChange={(e) =>{
                        setConTimeline(dayjs(e.target.value),false);
                    }}
                />

            </div>
        </div>

    </div>
            <div className="flex justify-end gap-5 my-3 mx-5">
                <SecondaryButton
                >
                    Preview
                </SecondaryButton>
                <PrimaryButton>
                    Export
                </PrimaryButton>
            </div>

    </>
);


}
