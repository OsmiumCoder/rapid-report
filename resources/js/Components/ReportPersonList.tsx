import AdditionalPerson from '@/types/AdditionalPerson'
import React from "react";


interface ReportPersonListProps {
    additionalPeople: Array<AdditionalPerson>
}

export default function ReportPersonList(additionalPeople: ReportPersonListProps) {
    return (<>
            {additionalPeople.additionalPeople.length>0 && (
        <ul role="list" className="divide-y divide-gray-100">
            {additionalPeople.additionalPeople.map((person) => (
                <li key={person.index} className="flex gap-x-4 py-5">
                    <span className="inline-block size-12 overflow-hidden rounded-full bg-gray-100">
                        <svg fill="currentColor" viewBox="0 0 24 24" className="size-full text-gray-300">
                            <path
                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </span>
                    <div className="min-w-0">
                        <p className="text-sm/6 font-semibold text-gray-900">{person.name}</p>
                        <p className="mt-1 truncate text-xs/5 text-gray-500">{person.email}</p>
                        <p className="mt-1 truncate text-xs/5 text-gray-500">{person.phone}</p>
                    </div>
                </li>
            ))}
        </ul>
        )}
        {additionalPeople.additionalPeople.length===0 && (
            <p className=" flex justify-center text-gray-500">
                Currently No Additions!
            </p>
        )}
        </>
    )
}
