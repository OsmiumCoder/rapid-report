import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { EllipsisVerticalIcon } from '@heroicons/react/20/solid';
import { Incident } from '@/types/incident/Incident';

export default function IncidentHeader({ incident }: { incident: Incident }) {
    return (
        <>
            <header className="relative isolate">
                <div className="mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none">
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
                                <div className="mt-1 text-base font-semibold text-gray-900">
                                    UPEI Health & Safety
                                </div>
                            </h1>
                        </div>
                        <div className="flex items-center gap-x-4 sm:gap-x-6">
                            <button
                                type="button"
                                className="hidden text-sm/6 font-semibold text-gray-900 sm:block"
                            >
                                Copy URL
                            </button>
                            <a
                                href="#"
                                className="hidden text-sm/6 font-semibold text-gray-900 sm:block"
                            >
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
                                    <EllipsisVerticalIcon
                                        aria-hidden="true"
                                        className="size-5 text-gray-500"
                                    />
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
