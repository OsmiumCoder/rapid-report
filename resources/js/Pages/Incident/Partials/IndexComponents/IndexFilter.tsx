import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/react';
import { FunnelIcon } from '@heroicons/react/20/solid';
import { descriptors } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import React, { Dispatch, SetStateAction, useState } from 'react';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import classNames from '@/Filters/classNames';
import { Filter, FilterValue } from '@/Pages/Incident/Index';
import dateFormat from '@/Filters/dateFormat';
import LabeledCheckbox from '@/Components/LabeledCheckbox';

interface IndexFilterProps {
    filters: Record<FilterValue, Filter[]>;
    setFilters: Dispatch<SetStateAction<Record<FilterValue, Filter[]>>>;
    resetFilters: () => void;
}

export default function IndexFilter({ filters, setFilters, resetFilters }: IndexFilterProps) {
    const [isFilterShowing, setIsFilterShowing] = useState(false);

    const numberOfFilters = () =>
        Object.values(filters).reduce((prev, current) => {
            return (
                prev +
                current.reduce(
                    (prevInner, currentInner) => prevInner + (currentInner.checked ? 1 : 0),
                    0
                )
            );
        }, 0);

    const commonDescriptors = descriptors
        .map((descriptor) => descriptor.options)
        .reduce((common, options) => common.filter((option) => options.includes(option)));

    const excludeDescriptor = (descr: string) => {
        const type = descriptors.find((descriptor) =>
            descriptor.options.some((option) => option === descr)
        )?.name;

        return (
            !filters.incident_type.find(({ label }) => label.toLowerCase() === type?.toLowerCase())
                ?.checked && !commonDescriptors.includes(descr)
        );
    };

    const handleSelectFilter = (filterName: FilterValue, innerIndex: number, checked: boolean) => {
        setFilters((prev) => ({
            ...prev,
            [filterName]: filters[filterName as FilterValue].map((filter, i) =>
                innerIndex === i
                    ? {
                          ...filter,
                          checked,
                      }
                    : {
                          ...filter,
                      }
            ),
        }));
    };

    return (
        <div className="my-2 rounded-lg">
            {/* Filters */}
            <Disclosure as="section" aria-labelledby="filter-heading" className="grid items-center">
                <h2 id="filter-heading" className="sr-only">
                    Filters
                </h2>
                <div className="relative col-start-1 row-start-1 py-4">
                    <div className="mx-auto flex divide-x divide-gray-200 text-sm ml-2 mt-2">
                        <div
                            className={classNames(
                                'pr-6 hover:text-gray-900',
                                numberOfFilters() > 0 || isFilterShowing
                                    ? 'text-gray-900'
                                    : 'text-gray-500'
                            )}
                        >
                            <DisclosureButton
                                className="group flex items-center font-medium"
                                onClick={() => setIsFilterShowing((prev) => !prev)}
                            >
                                <FunnelIcon aria-hidden="true" className="mr-2 size-5 flex-none" />
                                <span>{numberOfFilters() + ' Filters'}</span>
                            </DisclosureButton>
                        </div>
                        <div className="pl-6">
                            <button
                                type="button"
                                className="text-gray-500 hover:text-gray-900"
                                onClick={() => resetFilters()}
                            >
                                Clear all
                            </button>
                        </div>
                    </div>
                </div>
                <DisclosurePanel className="border-t border-gray-200 py-10">
                    <div className="max-w-7xl gap-x-4 px-4 text-sm sm:px-6 md:gap-x-6">
                        <div className="grid grid-cols-1 items-stretch gap-x-6 gap-y-6 md:grid-cols-4 md:gap-x-6">
                            {Object.entries(filters).map(([filterName, filter], filterIndex) => (
                                <>
                                    <fieldset
                                        key={filterIndex + filterName}
                                        className="space-y-4 max-h-64 overflow-y-scroll transparent-scrollbar"
                                    >
                                        <legend className="block font-medium text-lg">
                                            {uppercaseWordFormat(filterName)}
                                        </legend>
                                        {filterName === 'created_at' ? (
                                            <>
                                                {filters[filterName].map((filter, i) => (
                                                    <div
                                                        key={i + filter.label}
                                                        className="ml-2 grid space-y-6 sm:space-y-4"
                                                    >
                                                        <label>{filter.label}</label>
                                                        <input
                                                            type="date"
                                                            value={filter.value}
                                                            min={
                                                                filter.label === 'To'
                                                                    ? dateFormat(
                                                                          filters[filterName][0]
                                                                              .value
                                                                      )
                                                                    : undefined
                                                            }
                                                            onChange={(e) => {
                                                                setFilters((prev) => ({
                                                                    ...prev,
                                                                    created_at: prev.created_at.map(
                                                                        (dateFilter) => ({
                                                                            ...dateFilter,
                                                                            value:
                                                                                dateFilter.label ===
                                                                                filter.label
                                                                                    ? e.target.value
                                                                                    : dateFilter.value,
                                                                            checked:
                                                                                dateFilter.label ===
                                                                                filter.label
                                                                                    ? e.target.value
                                                                                          .length >
                                                                                      0
                                                                                    : dateFilter.checked,
                                                                        })
                                                                    ),
                                                                }));
                                                            }}
                                                            className="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                                                        />
                                                    </div>
                                                ))}
                                            </>
                                        ) : (
                                            <div className="grid space-y-6 sm:space-y-4">
                                                {filter.map(
                                                    ({ value, label, checked }, innerIndex) => (
                                                        <>
                                                            {!(
                                                                (filterName as FilterValue) ===
                                                                    'descriptor' &&
                                                                excludeDescriptor(value) &&
                                                                !commonDescriptors.includes(value)
                                                            ) && (
                                                                <LabeledCheckbox
                                                                    key={innerIndex + value}
                                                                    checked={checked}
                                                                    label={label}
                                                                    onChange={(e) =>
                                                                        handleSelectFilter(
                                                                            filterName as FilterValue,
                                                                            innerIndex,
                                                                            e.target.checked
                                                                        )
                                                                    }
                                                                />
                                                            )}
                                                        </>
                                                    )
                                                )}
                                            </div>
                                        )}
                                    </fieldset>
                                </>
                            ))}
                        </div>
                    </div>
                </DisclosurePanel>
            </Disclosure>
        </div>
    );
}
