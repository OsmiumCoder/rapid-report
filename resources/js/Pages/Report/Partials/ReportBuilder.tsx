import DateInput from '@/Components/DateInput';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import PrimaryButton from '@/Components/PrimaryButton';
import SelectInput from '@/Components/SelectInput';
import classNames from '@/Formatters/classNames';
import dateFormat from '@/Formatters/dateFormat';
import { uppercaseWordFormat } from '@/Formatters/uppercaseWordFormat';
import { downloadFile } from '@/Helpers/downloadFile';
import { Field, Label, Switch } from '@headlessui/react';
import axios from 'axios';
import dayjs, { ManipulateType } from 'dayjs';
import {useState} from 'react';
import {useForm} from "@inertiajs/react";
import _ from 'underscore';

interface RelativeTimeUnit {
    unit: ManipulateType;
    options: number[];
}

export default function ReportBuilder() {
    const fields = [
        'slug',
        'happened_at',
        'location',
        'room_number',
        'incident_type',
        'descriptor',
        'description',
        'injury_description',
        'first_aid_description',
        'created_at',
        'status',
        'closed_at',
    ];

    const { data, setData } = useForm({
        start: dateFormat(dayjs().subtract(1, 'year').toDate()),
        end: dateFormat(dayjs().toDate()),
        fields: [] as string[]
    });

    const toggleSelectedFields = (value: string, isChecked: boolean) => {
        const updatedFields = isChecked && !data.fields.includes(value)
            ? [...data.fields, value]
            : data.fields.filter((item) => item !== value);

        setData('fields', updatedFields);
    };

    const [relativeTimeFrameSelected, setRelativeTimeFrameSelected] = useState(false);

    const setTimePeriod = (start: string, end: string) => {
        if (data.start != start && dayjs(start).isAfter(dayjs(end))) {
            end = dateFormat(dayjs(start).add(1, 'day').toDate());
        }
        else if (data.end != end && dayjs(end).isBefore(dayjs(start))) {
            start = dateFormat(dayjs(end).subtract(1, 'day').toDate());
        }

        setData('start', start);
        setData('end', end);
    };

    const setRelativeTimePeriod = (value: number, unit: ManipulateType) => {
        setData('end', dateFormat(dayjs().toDate()));

        const start = dateFormat(dayjs(data.end).subtract(value, unit).toDate());

        setData('start', start);
    };

    const relativeTimeUnits: RelativeTimeUnit[] = [
        {
            unit: 'day',
            options: _.range(1, 8),
        },
        {
            unit: 'week',
            options: _.range(1, 5),
        },
        {
            unit: 'month',
            options: _.range(1, 13),
        },
        {
            unit: 'year',
            options: _.range(1, 6),
        }
    ];

    const [selectedRelativeTimeLength, setSelectedRelativeTimeLength] = useState(1);
    const [selectedRelativeTimeUnit, setSelectedRelativeTimeUnit] = useState<ManipulateType>("day");

    const downloadExcel = async () => {
        const response = await axios.post(route('report.export-xlsx'), data, {
            responseType: 'blob',
        });

        const fileName = response.headers["content-disposition"].split('filename=')[1]

        downloadFile(response.data, fileName);
    };

    const downloadCSV = async () => {
        const response = await axios.post(route('report.export-csv'), data, {
            responseType: 'blob',
        });

        const fileName = response.headers["content-disposition"].split('filename=')[1]

        downloadFile(response.data, fileName);
    };

    return (
        <div className="mx-4 space-y-6 rounded-xl bg-white p-4 shadow-lg">
            <div className="text-black-500 text-lg font-semibold sm:text-xl/8">Build your report:</div>
            <div>
                <p className="text-m text-black-500">Select Categories for Export:</p>
                <div className="mt-2 grid grid-rows-1 md:grid-cols-2 lg:grid-cols-3">
                    {fields.map((value, index) => (
                        <LabeledCheckbox
                            key={index}
                            label={uppercaseWordFormat(value)}
                            onChange={(e) => toggleSelectedFields(value, e.target.checked)}
                        />
                    ))}
                </div>
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
                                onChange={(isRelative) => {
                                    if (isRelative) {
                                        setSelectedRelativeTimeLength(1);
                                        setSelectedRelativeTimeUnit('day');
                                        setRelativeTimePeriod(selectedRelativeTimeLength, selectedRelativeTimeUnit)
                                    }
                                    else {
                                        setTimePeriod(dateFormat(dayjs().subtract(1, 'year').toDate()), dateFormat(dayjs().toDate()));
                                    }

                                    setRelativeTimeFrameSelected(isRelative);
                                }}
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
                                value={selectedRelativeTimeLength}
                                onChange={(e) => {
                                    setSelectedRelativeTimeLength(parseInt(e.target.value));
                                    setRelativeTimePeriod(parseInt(e.target.value), selectedRelativeTimeUnit);
                                }}
                            >
                                {relativeTimeUnits
                                    .find((element) => element.unit === selectedRelativeTimeUnit)!
                                    .options.map((value, index) => (
                                        <option key={index}>{value}</option>
                                    ))}
                            </SelectInput>
                            <SelectInput
                                value={selectedRelativeTimeUnit}
                                onChange={(e) => {
                                    setSelectedRelativeTimeLength(1);
                                    setSelectedRelativeTimeUnit(e.target.value as ManipulateType);
                                    setRelativeTimePeriod(selectedRelativeTimeLength, e.target.value as ManipulateType);
                                }}
                            >
                                {relativeTimeUnits.map((value, index) => (
                                    <option key={index}>{value.unit}</option>
                                ))}
                            </SelectInput>
                        </div>
                    ) : (
                        <div className="mt-4 flex w-1/2 gap-5">
                            <DateInput
                                value={data.start}
                                onChange={(e) => {
                                    setTimePeriod(dateFormat(e.target.value), data.end);
                                }}
                            />
                            <DateInput
                                value={data.end}
                                onChange={(e) => {
                                    setTimePeriod(data.start, dateFormat(e.target.value));
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
