import { Witness } from '@/types/incident/Witness';
import { XMarkIcon } from '@heroicons/react/20/solid';

interface WitnessListProps {
    witnesses: Array<Witness>;
    removeWitness: (index: number) => void;
}

export default function WitnessList({ witnesses, removeWitness }: WitnessListProps) {
    return (
        <>
            {witnesses.length > 0 && (
                <ul className="divide-y divide-gray-100 px-4">
                    {witnesses.map((person, index) => (
                        <li key={index} className="flex items-center justify-between gap-x-12 py-2">
                            <div>
                                <p className="text-sm/6 font-semibold text-gray-900">{person.name}</p>
                                <p className="mt-1 truncate text-xs/5 text-gray-500">{person.email}</p>
                                <p className="mt-1 truncate text-xs/5 text-gray-500">{person.phone}</p>
                            </div>
                            <div>
                                <button
                                    type="button"
                                    onClick={() => {
                                        removeWitness(index);
                                    }}
                                    className="cursor-pointer rounded-full bg-upei-red-600 p-2 text-white shadow-xs hover:bg-upei-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-upei-red-600"
                                >
                                    <XMarkIcon aria-hidden="true" className="size-5" />
                                </button>
                            </div>
                        </li>
                    ))}
                </ul>
            )}
            {witnesses.length === 0 && <p className="flex justify-center text-gray-500">No individuals have been added.</p>}
        </>
    );
}
