import { useState } from 'react'
import {
    Dialog,
    DialogPanel,
    Label,
    Listbox,
    ListboxButton,
    ListboxOption,
    ListboxOptions,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from '@headlessui/react'
import {
    Bars3Icon,
    CalendarDaysIcon,
    CreditCardIcon,
    EllipsisVerticalIcon,
    FaceFrownIcon,
    FaceSmileIcon,
    FireIcon,
    HandThumbUpIcon,
    HeartIcon,
    PaperClipIcon,
    UserCircleIcon,
    XMarkIcon as XMarkIconMini,
} from '@heroicons/react/20/solid'
import { BellIcon, XMarkIcon as XMarkIconOutline } from '@heroicons/react/24/outline'
import { CheckCircleIcon } from '@heroicons/react/24/solid'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminActions from '@/Pages/Incident/Partials/AdminActions';
import ActivityLog from '@/Pages/Incident/Partials/ActivityLog';
import IncidentHeader from '@/Pages/Incident/Partials/IncidentHeader';
import { Head } from '@inertiajs/react';
import {PageProps} from "@/types";
import classNames from "@/Filters/classNames";

const moods = [
    { name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white', bgColor: 'bg-pink-400' },
    { name: 'Happy', value: 'happy', icon: FaceSmileIcon, iconColor: 'text-white', bgColor: 'bg-green-400' },
    { name: 'Sad', value: 'sad', icon: FaceFrownIcon, iconColor: 'text-white', bgColor: 'bg-yellow-400' },
    { name: 'Thumbsy', value: 'thumbsy', icon: HandThumbUpIcon, iconColor: 'text-white', bgColor: 'bg-blue-500' },
    { name: 'I feel nothing', value: null, icon: XMarkIconMini, iconColor: 'text-gray-400', bgColor: 'bg-transparent' },
]

export default function Index({incident}: PageProps<{ incident: any }>) {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
    const [selected, setSelected] = useState(moods[5])

    return (

        <AuthenticatedLayout>
            <Head title="Incident"/>
            <pre>{JSON.stringify(incident, null, 1)}</pre> {/* Remove this */}
            {/*
            delete <pre> {...} </pre>
            https://tailwindui.com/components/application-ui/page-examples/detail-screens
            then add empty tag <> ... </>
            null => N/A or Unavailable; except First-Aid and Injury
            First-Aid = No first-aid was administered.
            Injury = No injuries were sustained.

            Once page is complete, break down large items into components.
            Each component should be a file in the "Partials" dir

            AuthenticatedLayout.tsx -> Line #20 is an example

            NavigationItems.tsx has good examples for React

            Time spent:
            Jan. 18th -> 1.5 hrs
            Jan. 19th -> 1 hr
            Jan. 20th -> 1.5 hr
            in a div, to get info from incident, use {incident.attribute} -> the attribute is what you want like id, name, date, etc...
            */}
            <>
                <header className="absolute inset-x-0 top-0 z-50 flex h-16 border-b border-gray-900/10">
                    <div className="mx-auto flex w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
                        <div className="flex flex-1 items-center gap-x-6">
                            <button type="button" onClick={() => setMobileMenuOpen(true)}
                                    className="-m-3 p-3 md:hidden">
                                <span className="sr-only">Open main menu</span>
                                <Bars3Icon aria-hidden="true" className="size-5 text-gray-900"/>
                            </button>
                            <img
                                alt="Your Company"
                                src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                                className="h-8 w-auto"
                            />
                        </div>
                    </div>
                    <Dialog open={mobileMenuOpen} onClose={setMobileMenuOpen} className="lg:hidden">
                        <div className="fixed inset-0 z-50"/>
                        <DialogPanel
                            className="fixed inset-y-0 left-0 z-50 w-full overflow-y-auto bg-white px-4 pb-6 sm:max-w-sm sm:px-6 sm:ring-1 sm:ring-gray-900/10">
                            <div className="-ml-0.5 flex h-16 items-center gap-x-6">
                                <button type="button" onClick={() => setMobileMenuOpen(false)}
                                        className="-m-2.5 p-2.5 text-gray-700">
                                    <span className="sr-only">Close menu</span>
                                    <XMarkIconOutline aria-hidden="true" className="size-6"/>
                                </button>
                                <div className="-ml-0.5">
                                    <a href="#" className="-m-1.5 block p-1.5">
                                        <span className="sr-only">Your Company</span>
                                        <img
                                            alt=""
                                            src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=600"
                                            className="h-8 w-auto"
                                        />
                                    </a>
                                </div>
                            </div>
                        </DialogPanel>
                    </Dialog>
                </header>

                <main>
                    {/* Incident Header */}
                    <IncidentHeader incident={incident}></IncidentHeader>

                    <div className="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                        <div
                            className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            {/* Admin actions box (placeholder) -> top-right */}
                            <AdminActions incident={incident}></AdminActions>

                            {/* Incident Information Section */}
                            <div
                                className="-mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
                                <h2 className="text-base font-semibold text-gray-900">Incident</h2>
                                <dl className="mt-6 grid grid-cols-1 text-sm/6 sm:grid-cols-2">
                                    <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                                        <dt className="font-semibold text-gray-900">Summary</dt>
                                        {' '}

                                    </div>
                                    <br/>
                                    <br/>
                                    <div className="sm:pr-4">
                                        <dt className="inline text-gray-500">Created:</dt>
                                        {' '}
                                        <dd className="inline text-gray-700">
                                            <time>{incident.created_at}</time>
                                        </dd>
                                    </div>
                                    <br/>
                                    <div className="sm:pr-4">
                                        <dt className="inline text-gray-500">Last Updated:</dt>
                                        {' '}
                                        <dd className="inline text-gray-700">
                                            <time>{incident.updated_at}</time>
                                        </dd>
                                    </div>
                                    <br/>
                                    <div className="sm:pr-4">
                                        <dt className="inline text-gray-500">Status:</dt>
                                        {' '}
                                        <dd className="inline text-gray-700">
                                            <time>{incident.status}</time>
                                        </dd>
                                    </div>
                                    <br/>
                                    <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                                        <dt className="font-semibold text-gray-900">Reporting user</dt>
                                        <dd className="mt-2 text-gray-500">
                                            <span
                                                className="font-medium text-gray-900">{incident.first_name} {incident.last_name}</span>
                                            <br/>
                                            UPEI ID: {incident.upei_id || "Not Applicable"}
                                            <br/>
                                            Email: {incident.email}
                                            <br/>
                                            Phone: {incident.phone}
                                            <br/>
                                        </dd>
                                    </div>
                                    <br/>
                                    <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                                        <dt className="font-semibold text-gray-900">Supervisor</dt>
                                        <dd className="mt-2 text-gray-500">
                                            <span
                                                className="font-medium text-gray-900">{incident.supervisor_name || "None given"}</span>
                                            <br/>
                                            Email: {incident.reporters_email}
                                            <br/>
                                            ID: {incident.supervisor_id || "None"}
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                            {/* Activity Log + Comment Form */}
                            <ActivityLog incident={incident}></ActivityLog>
                        </div>
                    </div>
                </main>
            </>
        </AuthenticatedLayout>
    );
}
