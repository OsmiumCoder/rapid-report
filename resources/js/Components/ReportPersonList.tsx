import AdditionalPerson from '@/types/AdditionalPerson';
import React from 'react';
import { XMarkIcon } from '@heroicons/react/20/solid';

interface ReportPersonListProps {
    additionalPeople: Array<AdditionalPerson>;
    removeFunction: Function;
}

export default function ReportPersonList({
    additionalPeople,
    removeFunction,
}: ReportPersonListProps) {
    return (
        <>
            {additionalPeople.length > 0 && (
                <ul
                    className="px-4 divide-y divide-gray-100"
                >
                    {additionalPeople.map((person) => (
                        <li
                            key={person.index}
                            className="py-2 flex justify-between gap-x-12 items-center"
                        >
                            <div>
                                <p className="text-sm/6 font-semibold text-gray-900">
                                    {person.name}
                                </p>
                                <p className="mt-1 truncate text-xs/5 text-gray-500">
                                    {person.email}
                                </p>
                                <p className="mt-1 truncate text-xs/5 text-gray-500">
                                    {person.phone}
                                </p>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    onClick={() => {
                                        removeFunction(person.index);
                                    }}
                                    className="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                                >
                                    <XMarkIcon
                                        aria-hidden="true"
                                        className="size-5"
                                    />
                                </button>
                            </div>
                        </li>
                    ))}
                </ul>
            )}
            {additionalPeople.length === 0 && (
                <p className=" flex justify-center text-gray-500">
                    No individuals have been added.
                </p>
            )}
        </>
    );
}
