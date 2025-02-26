import DateInput from '@/Components/DateInput';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import PrimaryButton from '@/Components/PrimaryButton';
import SelectInput from '@/Components/SelectInput';
import classNames from '@/Filters/classNames';
import dateFormat from '@/Filters/dateFormat';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { downloadFile } from '@/Helpers/downloadFile';
import ReportData from '@/types/report/ReportData';
import { Field, Label, Switch } from '@headlessui/react';
import axios from 'axios';
import dayjs, { Dayjs, ManipulateType } from 'dayjs';
import { useEffect, useState } from 'react';

export interface ReportBuilderProps {
    formData: ReportData;
    setFormData: (key: keyof ReportData, value: ReportData[keyof ReportData]) => void;
}

interface TimelineLengths {
    stringify: string;
    stringifyPlural: string;
    unit: ManipulateType;
}

interface Timeline {
    startDate: Dayjs;
    endDate: Dayjs;
}

interface Relative {
    unit: TimelineLengths;
    iter: number;
}

type TimeLengthsCollection = {
    [key: string]: TimelineLengths;
};

export default function ReportBuilder({ formData, setFormData }: ReportBuilderProps) {
    const currentDate = dayjs(new Date());

    const [timeline, setTimeline] = useState<Timeline>({
        startDate: currentDate.subtract(1, 'day'),
        endDate: currentDate,
    });

    const setRelativeTimeline = (iter: number, unit: ManipulateType) => {
        if (unit !== 'millisecond') {
            setTimeline(() => ({
                startDate: currentDate.subtract(iter, unit),
                endDate: currentDate,
            }));
        } else {
            setTimeline(() => ({
                startDate: dayjs(0),
                endDate: currentDate,
            }));
        }
    };
    const setConTimeline = (date: Dayjs, isStart: boolean) => {
        if (isStart) {
            if (date.isAfter(timeline.endDate) || date.isSame(timeline.endDate)) {
                setTimeline({
                    endDate: date.add(1, 'day'),
                    startDate: date,
                });
            } else {
                setTimeline((prev) => ({
                    ...prev,
                    startDate: date,
                }));
            }
        } else {
            if (date.isBefore(timeline.startDate) || date.isSame(timeline.endDate)) {
                setTimeline({
                    endDate: date,
                    startDate: date.subtract(1, 'day'),
                });
            } else {
                setTimeline((prev) => ({
                    ...prev,
                    endDate: date,
                }));
            }
        }
    };

    useEffect(() => {
        setFormData('start', timeline.startDate.format('YYYY-MM-DD'));
        setFormData('end', timeline.endDate.format('YYYY-MM-DD'));
    }, [setFormData, timeline]);

    const downloadExcel = async () => {
        const response = await axios.post(route('report.downloadFileXLSX'), formData, {
            responseType: 'arraybuffer',
        });

        const blob = new Blob([response.data], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        });

        downloadFile(blob, `${dateFormat(Date.now())} - report.xlsx`);
    };

    const downloadCSV = async () => {
        const response = await axios.post(route('report.downloadFileCSV', { ...formData }));

        const blob = new Blob([response.data], { type: 'text/csv' });

        downloadFile(blob, `${dateFormat(Date.now())} - report.csv`);
    };

    const timelineLengths: TimeLengthsCollection = {
        day: {
            stringify: 'Day',
            stringifyPlural: 'Days',
            unit: 'day',
        },
        week: {
            stringify: 'Week',
            stringifyPlural: 'Weeks',
            unit: 'week',
        },
        month: {
            stringify: 'Month',
            stringifyPlural: 'Months',
            unit: 'month',
        },
        year: {
            stringify: 'Year',
            stringifyPlural: 'Years',
            unit: 'year',
        },
        alltime: {
            stringify: 'All Time',
            stringifyPlural: 'All Time',
            unit: 'millisecond',
        },
    };
    const lengthItems = Object.keys(timelineLengths) as Array<keyof typeof timelineLengths>;

    const [timelineLength, setTimelineLength] = useState<Relative>({
        unit: timelineLengths.day,
        iter: 1,
    });

    const numIters = Array.from({ length: 12 }, (_, i) => i + 1);

    const formItems = (Object.keys(formData) as Array<keyof ReportData>).filter((key) => key !== 'start' && key !== 'end');

    const [relativeTimeFrameSelected, setRelativeTimeFrameSelected] = useState(false);

    return (
        <div className="mx-4 space-y-6 rounded-xl bg-white p-4 shadow-lg">
            <div className="text-black-500 text-lg font-semibold sm:text-xl/8">Build your report:</div>
            <div>
                <p className="text-m text-black-500">Select Categories for Export:</p>
                <ul className="mt-2 grid grid-rows-1 md:grid-cols-2 lg:grid-cols-3">
                    {formItems.map((key) => (
                        <li key={key}>
                            <LabeledCheckbox
                                checked={formData[key] as boolean}
                                onChange={(e) => setFormData(key, e.target.checked)}
                                label={uppercaseWordFormat(key)}
                            />
                        </li>
                    ))}
                </ul>
            </div>

            <div>
                <p className="text-m text-black-500">Time Period:</p>
                <div className="mt-2">
                    <div>
                        <Field className="flex items-center">
                            <Label as="span" className="mr-3 text-sm">
                                <span className={classNames(relativeTimeFrameSelected ? 'text-gray-400' : 'text-gray-900', 'font-medium')}>
                                    Static Time Frame
                                </span>
                            </Label>
                            <Switch
                                checked={relativeTimeFrameSelected}
                                onChange={setRelativeTimeFrameSelected}
                                className="group bg-upei-green-600 focus:ring-upei-green-600 relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:ring-2 focus:ring-offset-2 focus:outline-hidden"
                            >
                                <span
                                    aria-hidden="true"
                                    className="pointer-events-none inline-block size-5 transform rounded-full bg-white shadow-sm ring-0 transition duration-200 ease-in-out group-data-checked:translate-x-5"
                                />
                            </Switch>
                            <Label as="span" className="ml-3 text-sm">
                                <span className={classNames(relativeTimeFrameSelected ? 'text-gray-900' : 'text-gray-400', 'font-medium')}>
                                    Relative Time Frame
                                </span>
                            </Label>
                        </Field>
                    </div>

                    {relativeTimeFrameSelected ? (
                        <div className="mt-2 flex gap-5">
                            <SelectInput
                                value={timelineLength.iter}
                                onChange={(e) => {
                                    setTimelineLength((prev) => ({
                                        ...prev,
                                        iter: +e.target.value,
                                    }));
                                    setRelativeTimeline(+e.target.value, timelineLength.unit.unit);
                                }}
                            >
                                {numIters.map((i) => (
                                    <option key={i}>{i}</option>
                                ))}
                            </SelectInput>
                            <SelectInput
                                value={timelineLength.iter > 1 ? timelineLength.unit.stringifyPlural : timelineLength.unit.stringify}
                                onChange={(e) => {
                                    setTimelineLength((prev) => ({
                                        ...prev,
                                        unit: timelineLengths[
                                            e.target.value.slice(-1) == 's'
                                                ? e.target.value.toLowerCase().slice(0, -1)
                                                : e.target.value.toLowerCase().replace(/\s/g, '')
                                        ],
                                    }));
                                    setRelativeTimeline(
                                        timelineLength.iter,
                                        timelineLengths[
                                            e.target.value.slice(-1) == 's'
                                                ? e.target.value.toLowerCase().slice(0, -1)
                                                : e.target.value.toLowerCase().replace(/\s/g, '')
                                        ].unit,
                                    );
                                }}
                            >
                                {lengthItems.map((index, value) =>
                                    timelineLength.iter > 1 ? (
                                        <option key={value}>{timelineLengths[index].stringifyPlural}</option>
                                    ) : (
                                        <option key={value}>{timelineLengths[index].stringify}</option>
                                    ),
                                )}
                            </SelectInput>
                        </div>
                    ) : (
                        <div className="mt-4 flex w-1/2 gap-5">
                            <DateInput
                                value={timeline.startDate.format('YYYY-MM-DD')}
                                onChange={(e) => {
                                    setConTimeline(dayjs(e.target.value), true);
                                }}
                            />
                            <DateInput
                                value={timeline.endDate.format('YYYY-MM-DD')}
                                onChange={(e) => {
                                    setConTimeline(dayjs(e.target.value), false);
                                }}
                            />
                        </div>
                    )}
                </div>
            </div>

            <div className="flex w-full justify-center space-x-2">
                <PrimaryButton type={'button'} onClick={downloadCSV}>
                    Export as CSV
                </PrimaryButton>
                <PrimaryButton type={'button'} onClick={downloadExcel}>
                    Export as Excel
                </PrimaryButton>
            </div>
        </div>
    );
}
