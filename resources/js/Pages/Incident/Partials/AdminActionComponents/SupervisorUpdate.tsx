import { User } from '@/types';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { Incident } from '@/types/incident/Incident';
import {
    Listbox,
    ListboxButton,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/react';
import { ChevronUpDownIcon } from '@heroicons/react/16/solid';
import { useState } from 'react';
import LoadingIndicator from '@/Components/LoadingIndicator';
import SecondaryButton from '@/Components/SecondaryButton';
import {
    assignSupervisor,
    unassignSupervisor,
} from '@/Pages/Incident/Partials/AdminActionComponents/supervisorActions';
import ConfirmationModal, {
    ConfirmationModalProps,
    useConfirmationModalProps,
} from '@/Components/ConfirmationModal';

export default function SupervisorUpdate({
    incident,
    supervisors,
}: {
    incident: Incident;
    supervisors: User[];
}) {
    const [isLoading, setIsLoading] = useState(false);
    const [modalProps, setModalProps] = useConfirmationModalProps();

    return (
        <>
            <div className="mt-6 w-full border-t border-gray-900/5 pt-6 px-4">
                <div className="flex flex-wrap justify-center items-center w-full gap-x-4">
                    <div className="w-24 text-gray-900 font-medium">
                        Supervisor:
                    </div>
                    <Listbox
                        onChange={(id) => {
                            const supervisor = supervisors.find(
                                (supervisor) => supervisor.id === parseInt(id)
                            );

                            setModalProps((prev: ConfirmationModalProps) => ({
                                ...prev,
                                title: 'Assign Supervisor',
                                text: `Are you sure you want to assign ${supervisor?.name} to this incident?\n${supervisor?.name} will be notified.`,
                                action: () =>
                                    assignSupervisor(
                                        parseInt(id),
                                        incident,
                                        setIsLoading
                                    ),
                                show: true,
                            }));
                        }}
                        disabled={isLoading}
                    >
                        <div className="relative max-w-lg">
                            <ListboxButton className="inline-flex items-center justify-between min-w-32 h-8 w-full cursor-default grid-cols-1 rounded-md bg-white pl-3 pr-2 text-left text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm">
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
                        <SecondaryButton
                            onClick={() => {
                                setModalProps(
                                    (prev: ConfirmationModalProps) => ({
                                        ...prev,
                                        title: 'Unassign Supervisor',
                                        text: `Are you sure you want to unassign ${incident?.supervisor?.name} from this incident?`,
                                        action: () =>
                                            unassignSupervisor(
                                                incident,
                                                setIsLoading
                                            ),
                                        show: true,
                                    })
                                );
                            }}
                        >
                            Unassign
                        </SecondaryButton>
                    ) : (
                        <></>
                    )}
                </div>
            </div>
            <ConfirmationModal
                title={modalProps.title}
                text={modalProps.text}
                action={modalProps.action}
                show={modalProps.show}
                setShow={modalProps.setShow}
            />
        </>
    );
}
