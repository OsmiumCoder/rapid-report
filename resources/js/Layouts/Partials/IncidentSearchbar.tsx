import {
    Combobox,
    ComboboxInput,
    ComboboxOption,
    ComboboxOptions,
    Dialog,
    DialogBackdrop,
    DialogPanel,
} from '@headlessui/react';
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/react/20/solid';
import { Dispatch, SetStateAction, useEffect, useState } from 'react';
import { Incident } from '@/types/incident/Incident';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import axios from 'axios';
import { router } from '@inertiajs/react';

interface CommandPaletteProps {
    open: boolean;
    setOpen: Dispatch<SetStateAction<boolean>>;
}

const defaultLabels = [
    {
        label: 'Name',
        value: 'name',
        checked: false,
    },
    {
        label: 'UPEI ID',
        value: 'upei_id',
        checked: false,
    },
    {
        label: 'Location',
        value: 'location',
        checked: false,
    },
    {
        label: 'Room Number',
        value: 'room_number',
        checked: false,
    },
    {
        label: 'Injury Description',
        value: 'injury_description',
        checked: false,
    },
    {
        label: 'First Aid Description',
        value: 'first_aid_description',
        checked: false,
    },
    {
        label: 'Reporters Email',
        value: 'reporters_email',
        checked: false,
    },
    {
        label: 'Supervisor',
        value: 'supervisor',
        checked: false,
    },
    {
        label: 'Description',
        value: 'description',
        checked: false,
    },
    {
        label: 'Descriptor',
        value: 'descriptor',
        checked: false,
    },
    {
        label: 'Status',
        value: 'status',
        checked: false,
    },
];

export default function IncidentSearchbar({ open, setOpen }: CommandPaletteProps) {
    const [query, setQuery] = useState('');
    const [incidents, setIncidents] = useState<Incident[]>([]);
    const [sortByMenuOpen, setSortByMenuOpen] = useState(false);
    const [labels, setLabels] = useState(defaultLabels);
    const [searchBy, setSearchBy] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    useEffect(() => {
        setSearchBy(() => {
            const filteredLabels = labels.every(({ checked }) => !checked)
                ? labels
                : labels.filter(({ checked }) => checked);

            return filteredLabels.map(({ value }) => value).join(', ');
        });
    }, [labels]);

    useEffect(() => {
        if (query.length === 0) return;
        fetchIncidents();
    }, [query, searchBy]);

    const fetchIncidents = async () => {
        setIsLoading(true);
        try {
            const response = await axios.get<Incident[]>(
                route('incidents.search', { query, search_by: searchBy })
            );
            setIncidents(response.data);
        } catch (err) {
            console.error(err);
        } finally {
            setIsLoading(false);
        }
    };

    console.log(incidents);
    return (
        <Dialog
            className="relative z-10"
            open={open}
            onClose={() => {
                setOpen(false);
                setQuery('');
            }}
        >
            <DialogBackdrop
                transition
                className="fixed inset-0 bg-gray-500/25 transition-opacity data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in"
            />

            <div className="fixed inset-0 z-10 w-screen overflow-y-auto p-4 sm:p-6 md:p-20">
                <DialogPanel
                    transition
                    className="mx-auto max-w-xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black/5 transition-all data-[closed]:scale-95 data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in"
                >
                    <button
                        className="flex flex-row hover:cursor-pointer ml-6 mt-4 mb-2"
                        onClick={() => setSortByMenuOpen((prev) => !prev)}
                    >
                        <span>Search By</span>
                        <ChevronDownIcon className="size-6" />
                    </button>
                    {sortByMenuOpen && (
                        <div className="grid grid-cols-3 mx-6 mb-4">
                            {labels.map((label, index) => (
                                <LabeledCheckbox
                                    key={index + label.label}
                                    checked={label.checked}
                                    label={label.label}
                                    onChange={(e) =>
                                        setLabels((prev) => {
                                            prev[index].checked = e.target.checked;
                                            return [...prev];
                                        })
                                    }
                                />
                            ))}
                        </div>
                    )}
                    <Combobox>
                        <div className="grid grid-cols-1">
                            <ComboboxInput
                                autoFocus
                                className="col-start-1 row-start-1 h-12 w-full pl-11 pr-4 text-base text-gray-900 outline-none placeholder:text-gray-400 sm:text-sm"
                                placeholder="Search..."
                                onChange={(e) => setQuery(e.target.value)}
                                onBlur={() => setQuery('')}
                            />
                            <MagnifyingGlassIcon
                                className="pointer-events-none col-start-1 row-start-1 ml-4 size-5 self-center text-gray-400"
                                aria-hidden="true"
                            />
                        </div>

                        {incidents.length > 0 && (
                            <ComboboxOptions
                                static
                                className="max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800"
                            >
                                {incidents.map((incident) => (
                                    <ComboboxOption
                                        key={incident.id}
                                        value={incident.id}
                                        className="select-none px-4 py-2 hover:bg-indigo-600 hover:text-white hover:cursor-pointer"
                                        onClick={() =>
                                            router.get(
                                                route('incidents.show', { incident: incident.id })
                                            )
                                        }
                                    >
                                        {incident.first_name}
                                    </ComboboxOption>
                                ))}
                            </ComboboxOptions>
                        )}

                        {query !== '' && incidents.length === 0 && (
                            <p className="p-4 text-sm text-gray-500">No people found.</p>
                        )}
                    </Combobox>
                </DialogPanel>
            </div>
        </Dialog>
    );
}
