'use client'

import {useState} from 'react'
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
import {BellIcon, XMarkIcon as XMarkIconOutline} from '@heroicons/react/24/outline'
import {CheckCircleIcon} from '@heroicons/react/24/solid'

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import AdminActions from '@/Pages/Incident/Partials/AdminActions';
import ActivityLog from '@/Pages/Incident/Partials/ActivityLog';
import {Head} from '@inertiajs/react';
import {PageProps} from "@/types";
import classNames from "@/Filters/classNames";

const activity = [
    {id: 1, type: 'created', person: {name: 'Chelsea Hagon'}, date: '7d ago', dateTime: '2023-01-23T10:32'},
    {id: 2, type: 'edited', person: {name: 'Chelsea Hagon'}, date: '6d ago', dateTime: '2023-01-23T11:03'},
    {id: 3, type: 'sent', person: {name: 'Chelsea Hagon'}, date: '6d ago', dateTime: '2023-01-23T11:24'},
    {
        id: 4,
        type: 'commented',
        person: {
            name: 'Chelsea Hagon',
            imageUrl:
                'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        comment: 'Called client, they reassured me the invoice would be paid by the 25th.',
        date: '3d ago',
        dateTime: '2023-01-23T15:56',
    },
    {id: 5, type: 'viewed', person: {name: 'Alex Curren'}, date: '2d ago', dateTime: '2023-01-24T09:12'},
    {id: 6, type: 'paid', person: {name: 'Alex Curren'}, date: '1d ago', dateTime: '2023-01-24T09:20'},
]
const moods = [
    {name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500'},
    {name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white', bgColor: 'bg-pink-400'},
    {name: 'Happy', value: 'happy', icon: FaceSmileIcon, iconColor: 'text-white', bgColor: 'bg-green-400'},
    {name: 'Sad', value: 'sad', icon: FaceFrownIcon, iconColor: 'text-white', bgColor: 'bg-yellow-400'},
    {name: 'Thumbsy', value: 'thumbsy', icon: HandThumbUpIcon, iconColor: 'text-white', bgColor: 'bg-blue-500'},
    {name: 'I feel nothing', value: null, icon: XMarkIconMini, iconColor: 'text-gray-400', bgColor: 'bg-transparent'},
]

export default function IncidentHeader({incident}: PageProps<{ incident: any }>) {
    const [mobileMenuOpen, setMobileMenuOpen] = useState(false)
    const [selected, setSelected] = useState(moods[5])

    return (
        <>
            <header className="relative isolate pt-16">
                <div aria-hidden="true" className="absolute inset-0 -z-10 overflow-hidden">
                    <div
                        className="absolute left-16 top-full -mt-16 transform-gpu opacity-50 blur-3xl xl:left-1/2 xl:-ml-80">
                        <div
                            style={{
                                clipPath:
                                    'polygon(100% 38.5%, 82.6% 100%, 60.2% 37.7%, 52.4% 32.1%, 47.5% 41.8%, 45.2% 65.6%, 27.5% 23.4%, 0.1% 35.3%, 17.9% 0%, 27.7% 23.4%, 76.2% 2.5%, 74.2% 56%, 100% 38.5%)',
                            }}
                            className="aspect-[1154/678] w-[72.125rem] bg-gradient-to-br from-[#FF80B5] to-[#9089FC]"
                        />
                    </div>
                    <div className="absolute inset-x-0 bottom-0 h-px bg-gray-900/5"/>
                </div>

                <div className="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                    <div
                        className="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none">
                        <div className="flex items-center gap-x-6">
                            <img
                                alt=""
                                src="https://tailwindui.com/plus/img/logos/48x48/tuple.svg"
                                className="size-16 flex-none rounded-full ring-1 ring-gray-900/10"
                            />
                            <h1>
                                <div className="text-sm/6 text-gray-500">
                                    Incident <span className="text-gray-700">{incident.id}</span>
                                </div>
                                <div className="mt-1 text-base font-semibold text-gray-900">Tuple, Inc</div>
                            </h1>
                        </div>
                        <div className="flex items-center gap-x-4 sm:gap-x-6">
                            <button type="button"
                                    className="hidden text-sm/6 font-semibold text-gray-900 sm:block">
                                Copy URL
                            </button>
                            <a href="#" className="hidden text-sm/6 font-semibold text-gray-900 sm:block">
                                Edit
                            </a>
                            <a
                                href="#"
                                className="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                Send
                            </a>

                            <Menu as="div" className="relative sm:hidden">
                                <MenuButton className="-m-3 block p-3">
                                    <span className="sr-only">More</span>
                                    <EllipsisVerticalIcon aria-hidden="true" className="size-5 text-gray-500"/>
                                </MenuButton>

                                <MenuItems
                                    transition
                                    className="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 transition focus:outline-none data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-100 data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in"
                                >
                                    <MenuItem>
                                        <button
                                            type="button"
                                            className="block w-full px-3 py-1 text-left text-sm/6 text-gray-900 data-[focus]:bg-gray-50 data-[focus]:outline-none"
                                        >
                                            Copy URL
                                        </button>
                                    </MenuItem>
                                    <MenuItem>
                                        <a
                                            href="#"
                                            className="block px-3 py-1 text-sm/6 text-gray-900 data-[focus]:bg-gray-50 data-[focus]:outline-none"
                                        >
                                            Edit
                                        </a>
                                    </MenuItem>
                                </MenuItems>
                            </Menu>
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
}
