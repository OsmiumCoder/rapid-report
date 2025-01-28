import { User } from '@/types';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { Incident } from '@/types/Incident';
import {
    Listbox,
    ListboxButton,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/react';
import { ChevronUpDownIcon } from '@heroicons/react/16/solid';
import { router } from '@inertiajs/react';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import SecondaryButton from '@/Components/SecondaryButton';

export default function SupervisorUpdate({
    incident,
    supervisors,
}: {
    incident: Incident;
    supervisors: User[];
}) {
    const [isLoading, setIsLoading] = useState(false);

    const assignSupervisor = (supervisorId: number) => {
        setIsLoading(true);
        router.put(
            route('incidents.assign-supervisor', { incident: incident.id }),
            { supervisor_id: supervisorId },
            {
                onSuccess: (_) => {
                    router.reload({ only: ['incident'] });
                    setIsLoading(false);
                },
                preserveScroll: true,
            }
        );
    };

    const unassignSupervisor = () => {
        setIsLoading(true);
        router.put(
            route('incidents.unassign-supervisor', { incident: incident.id }),
            undefined,
            {
                onSuccess: (_) => {
                    router.reload({ only: ['incident'] });
                    setIsLoading(false);
                },
                preserveScroll: true,
            }
        );
    };

    return (
        <div className="mt-6 border-t border-gray-900/5 p-6">
            <div className="flex items-center w-full gap-x-4">
                <div className="w-24 text-gray-900 font-medium">
                    Supervisor:
                </div>
                <Listbox
                    onChange={(id) => assignSupervisor(parseInt(id))}
                    disabled={isLoading}
                >
                    <div className="relative">
                        <ListboxButton className="grid min-w-32 w-full cursor-default grid-cols-1 rounded-md bg-white py-1.5 pl-3 pr-2 text-left text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <span className="col-start-1 row-start-1 truncate pr-6">
                                {
                                    supervisors.find(
                                        (supervisor) =>
                                            supervisor.id ===
                                            incident.supervisor_id
                                    )?.name
                                }
                            </span>
                            <ChevronUpDownIcon
                                aria-hidden="true"
                                className="col-start-1 row-start-1 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            />
                        </ListboxButton>
                        <ListboxOptions
                            transition
                            className="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none data-[closed]:data-[leave]:opacity-0 data-[leave]:transition data-[leave]:duration-100 data-[leave]:ease-in sm:text-sm"
                        >
                            {supervisors.map(
                                (supervisor) =>
                                    supervisor.id !==
                                        incident.supervisor_id && (
                                        <ListboxOption
                                            key={supervisor.id}
                                            value={supervisor.id}
                                            className="group relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 data-[focus]:bg-indigo-600 data-[focus]:text-white data-[focus]:outline-none"
                                        >
                                            {uppercaseWordFormat(
                                                supervisor.name
                                            )}
                                        </ListboxOption>
                                    )
                            )}
                        </ListboxOptions>
                    </div>
                </Listbox>
                {isLoading ? (
                    <LoadingIndicator className="h-6 w-6 text-gray-500" />
                ) : incident.supervisor ? (
                    <SecondaryButton onClick={unassignSupervisor}>
                        Clear
                    </SecondaryButton>
                ) : (
                    <></>
                )}
            </div>
        </div>
    );
}
