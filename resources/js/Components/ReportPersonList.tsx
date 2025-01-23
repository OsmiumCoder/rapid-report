import AdditionalPerson from '@/types/AdditionalPerson'
import React from "react";
import { XMarkIcon } from '@heroicons/react/20/solid'

interface ReportPersonListProps {
    additionalPeople: Array<AdditionalPerson>,
    removeFunction: Function
}

export default function ReportPersonList({additionalPeople,removeFunction}: ReportPersonListProps) {
    return (<>
            {additionalPeople.length>0 && (
        <ul role="list" className="min-w-0 flex-1 justify-self-center divide-y divide-gray-100">
            {additionalPeople.map((person) => (
                <li key={person.index} className="flex gap-x-4 py-5">
                    <span className="size-12 overflow-hidden rounded-full bg-gray-100">
                        <svg fill="currentColor" viewBox="0 0 24 24" className="size-full text-gray-300">
                            <path
                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>
                    <div>
                        <p className="text-sm/6 font-semibold text-gray-900">{person.name}</p>
                        <p className="mt-1 truncate text-xs/5 text-gray-500">{person.email}</p>
                        <p className="mt-1 truncate text-xs/5 text-gray-500">{person.phone}</p>
                    </div>
                    <div className="m-2.5 ml-16 flex md:ml-4 min-w-0">
                    <button
                        type="button"
                        onClick= {() => {removeFunction(person.index)}}
                        className="rounded-full bg-red-600 p-2 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600"
                    >
                        <XMarkIcon aria-hidden="true" className="size-5" />
                    </button>
                    </div>
                </li>
            ))}
        </ul>
        )}
        {additionalPeople.length===0 && (
            <p className=" flex justify-center text-gray-500">
                Currently No Additions!
            </p>
        )}
        </>
    )
}
