import { User } from '@/types';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { Incident } from '@/types/incident/Incident';
import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
    Label,
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
import { CheckIcon, MagnifyingGlassIcon } from '@heroicons/react/20/solid';

export default function SupervisorUpdate({
    incident,
    supervisors,
}: {
    incident: Incident;
    supervisors: User[];
}) {
    const [isLoading, setIsLoading] = useState(false);
    const [modalProps, setModalProps] = useConfirmationModalProps();
    const [query, setQuery] = useState('');
    const [defaultText, setDefaultText] = useState<'Unassigned' | ''>('Unassigned');

    const filteredSupervisors =
        query === ''
            ? supervisors
            : supervisors.filter((supervisor) => {
                  return (
                      supervisor.name.toLowerCase().includes(query.toLowerCase()) ||
                      supervisor.email.toLowerCase().includes(query.toLowerCase())
                  );
              });

    return (
        <>
            <label className="block text-sm/6 font-medium text-gray-900 mt-6">
                Supervisor Management
            </label>

            <div className="flex flex-wrap justify-around w-3/4 mt-4">
                <Combobox
                    as="div"
                    value={
                        supervisors
                            .find((supervisor) => supervisor.id === incident.supervisor_id)
                            ?.id.toString() ?? defaultText
                    }
                    onChange={(id) => {
                        setQuery('');
                        if (!id) return;
                        const supervisor = supervisors.find(
                            (supervisor) => supervisor.id === parseInt(id)
                        );
                        setModalProps((prev: ConfirmationModalProps) => ({
                            ...prev,
                            title: 'Assign Supervisor',
                            text: `Are you sure you want to assign ${supervisor?.name} to this incident?\n${supervisor?.name} will be notified.`,
                            action: () => assignSupervisor(parseInt(id), incident, setIsLoading),
                            show: true,
                        }));
                    }}
                >
                    <div className="relative">
                        <ComboboxInput
                            className="block w-full rounded-md bg-white py-1.5 pl-3 pr-12 text-base text-gray-900 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"
                            onChange={(event) => setQuery(event.target.value)}
                            onClick={() => setDefaultText('')}
                            onBlur={() => {
                                setDefaultText('Unassigned');
                                setQuery('');
                            }}
                            displayValue={() => incident.supervisor?.name ?? defaultText}
                        />
                        <ComboboxButton className="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                            <ChevronUpDownIcon
                                className="size-5 text-gray-400"
                                aria-hidden="true"
                            />
                        </ComboboxButton>

                        {supervisors.length > 0 && (
                            <ComboboxOptions className="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm">
                                {filteredSupervisors.map((supervisor) => (
                                    <ComboboxOption
                                        key={supervisor.id}
                                        value={supervisor.id}
                                        className="group relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900 data-[focus]:bg-indigo-600 data-[focus]:text-white data-[focus]:outline-none"
                                    >
                                        <div className="">
                                            <div className="group-data-[selected]:font-semibold">
                                                {supervisor.name}
                                            </div>
                                            <div className="text-gray-500 group-data-[focus]:text-indigo-200">
                                                {supervisor.email}
                                            </div>
                                        </div>

                                        {supervisor.id === incident.supervisor_id && (
                                            <span className="absolute flex inset-y-0 right-0 items-center pr-4 text-indigo-600 group-data-[focus]:text-white">
                                                <CheckIcon className="size-5" aria-hidden="true" />
                                            </span>
                                        )}
                                    </ComboboxOption>
                                ))}
                            </ComboboxOptions>
                        )}
                    </div>
                </Combobox>
                {isLoading ? (
                    <LoadingIndicator className="h-6 w-6 text-gray-500" />
                ) : incident.supervisor ? (
                    <SecondaryButton
                        onClick={() =>
                            setModalProps((prev: ConfirmationModalProps) => ({
                                ...prev,
                                title: 'Unassign Supervisor',
                                text: `Are you sure you want to unassign ${incident?.supervisor?.name} from this incident?`,
                                action: () => unassignSupervisor(incident, setIsLoading),
                                show: true,
                            }))
                        }
                    >
                        Unassign
                    </SecondaryButton>
                ) : (
                    <></>
                )}
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
