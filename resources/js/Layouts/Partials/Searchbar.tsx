import {
    Combobox,
    ComboboxOption,
    ComboboxOptions,
    Dialog,
    DialogBackdrop,
    DialogPanel,
} from '@headlessui/react';
import { ChevronDownIcon, ChevronUpIcon, MagnifyingGlassIcon } from '@heroicons/react/20/solid';
import { Dispatch, SetStateAction, useCallback, useEffect, useRef, useState } from 'react';
import { Incident } from '@/types/incident/Incident';
import LabeledCheckbox from '@/Components/LabeledCheckbox';
import axios from 'axios';
import { router } from '@inertiajs/react';
import _ from 'underscore';
import LoadingIndicator from '@/Components/LoadingIndicator';
import dateFormat from '@/Filters/dateFormat';
import Badge from '@/Components/Badge';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import { incidentBadgeColor } from '@/Filters/incidentBadgeColor';

interface CommandPaletteProps {
    open: boolean;
    setOpen: Dispatch<SetStateAction<boolean>>;
}

const defaultLabels = [
    {
        label: 'Name',
        value: 'first_name, last_name',
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
        value: 'supervisor, supervisor_name',
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

export default function Searchbar({ open, setOpen }: CommandPaletteProps) {
    const [search, setSearch] = useState('');
    const [incidents, setIncidents] = useState<Incident[]>([]);
    const [sortByMenuOpen, setSortByMenuOpen] = useState(false);
    const [labels, setLabels] = useState(defaultLabels);
    const [allLabelsChecked, setAllLabelsChecked] = useState(true);
    const [searchBy, setSearchBy] = useState('');
    const [isLoading, setIsLoading] = useState(false);

    const searchRef = useRef<string>(search);
    const searchByRef = useRef<string>(searchBy);

    const abortControllerRef = useRef<AbortController | null>(null);

    useEffect(() => {
        setSearchBy(() => {
            const filteredLabels = allLabelsChecked
                ? labels
                : labels.filter(({ checked }) => checked);

            return filteredLabels.map(({ value }) => value).join(', ');
        });
    }, [labels]);

    useEffect(() => {
        searchRef.current = search;
        searchByRef.current = searchBy;

        if (search.length === 0) {
            setIncidents([]);
        } else {
            fetchIncidents();
        }

        return () => abortControllerRef.current?.abort();
    }, [search, searchBy]);

    const fetchIncidents = useCallback(
        _.debounce(async () => {
            if (abortControllerRef.current) {
                abortControllerRef.current.abort();
            }

            const abortController = new AbortController();
            abortControllerRef.current = abortController;

            setIsLoading(true);
            try {
                const response = await axios.get<Incident[]>(
                    route('incidents.search', {
                        search: searchRef.current,
                        search_by: searchByRef.current,
                    }),
                    {
                        signal: abortController.signal,
                    }
                );
                setIncidents(response.data);
            } catch (err) {
                console.error(err);
            } finally {
                setIsLoading(false);
            }
        }, 250),
        []
    );

    useEffect(() => {
        setLabels((prev) => prev.map((label) => ({ ...label, checked: allLabelsChecked })));
    }, [allLabelsChecked]);

    return (
        <Dialog
            className="z-10"
            open={open}
            onClose={() => {
                setOpen(false);
            }}
        >
            <DialogBackdrop
                transition
                className="fixed inset-0 bg-gray-500/25 transition-opacity data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in"
            />

            <div className="fixed inset-0 z-[100] w-screen overflow-y-auto p-4 sm:p-6 md:p-20">
                <DialogPanel
                    transition
                    className="mx-auto max-w-xl transform overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black/5 transition-all data-[closed]:scale-95 data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in"
                >
                    <button
                        className="flex flex-row hover:cursor-pointer ml-6 mt-4 mb-2"
                        onClick={() => setSortByMenuOpen((prev) => !prev)}
                    >
                        <span className="mr-1">Search By</span>
                        {sortByMenuOpen ? (
                            <ChevronUpIcon className="size-6" />
                        ) : (
                            <ChevronDownIcon className="size-6" />
                        )}
                    </button>
                    {sortByMenuOpen && (
                        <div className="grid grid-rows-1 md:grid-cols-2 lg:grid-cols-3 mx-6 mb-4">
                            <LabeledCheckbox
                                checked={allLabelsChecked}
                                label="All"
                                onChange={(e) => setAllLabelsChecked(e.target.checked)}
                            />
                            {labels.map((label, index) => (
                                <LabeledCheckbox
                                    key={index + label.label}
                                    checked={label.checked}
                                    label={label.label}
                                    disabled={allLabelsChecked}
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
                            <input
                                className="col-start-1 row-start-1 h-12 w-full pl-11 pr-4 text-base text-gray-900 border-none focus:outline-0 focus:ring-0 placeholder:text-gray-400 sm:text-sm"
                                placeholder="Search..."
                                onChange={(e) => setSearch(e.target.value)}
                            />
                            <MagnifyingGlassIcon
                                className="pointer-events-none col-start-1 row-start-1 ml-4 size-5 self-center text-gray-400"
                                aria-hidden="true"
                            />
                        </div>

                        {!isLoading && incidents.length > 0 && (
                            <ComboboxOptions
                                static
                                className="max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800 divide-y divide-gray-100"
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
                                        <div className="mb-2">
                                            <span>{dateFormat(incident.created_at)}</span>
                                            <span> | </span>
                                            <span>
                                                {incident.first_name} {incident.last_name}
                                            </span>
                                            <span> | </span>
                                            <span>{incident.descriptor}</span>
                                            {incident.location && <div>{incident.location}</div>}
                                        </div>
                                        <Badge
                                            color={incidentBadgeColor(incident)}
                                            text={uppercaseWordFormat(incident.status)}
                                        />
                                    </ComboboxOption>
                                ))}
                            </ComboboxOptions>
                        )}

                        {!isLoading && search !== '' && incidents.length === 0 && (
                            <p className="p-4 text-sm text-gray-500">No incidents found.</p>
                        )}
                        {isLoading && (
                            <div className="flex items-center justify-center py-2">
                                <LoadingIndicator className="self-center" />
                            </div>
                        )}
                    </Combobox>
                </DialogPanel>
            </div>
        </Dialog>
    );
}
