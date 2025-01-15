import {Dialog, DialogBackdrop, DialogPanel, TransitionChild} from "@headlessui/react";
import {
    XMarkIcon
} from "@heroicons/react/24/outline";

import NavigationItems from "@/Layouts/Partials/NavigationItems";

function classNames(...classes: string[]) {
    return classes.filter(Boolean).join(' ')
}

export default function MobileSidebar(props: {
    open: boolean,
    onClose: (value: (((prevState: boolean) => boolean) | boolean)) => void,
    onClick: () => void,
}) {
    return <Dialog open={props.open} onClose={props.onClose} className="relative z-50 lg:hidden">
        <DialogBackdrop
            transition
            className="fixed inset-0 bg-gray-900/80 transition-opacity duration-300 ease-linear data-[closed]:opacity-0"
        />

        <div className="fixed inset-0 flex">
            <DialogPanel
                transition
                className="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out data-[closed]:-translate-x-full"
            >
                <TransitionChild>
                    <div
                        className="absolute left-full top-0 flex w-16 justify-center pt-5 duration-300 ease-in-out data-[closed]:opacity-0">
                        <button type="button" onClick={props.onClick}
                                className="-m-2.5 p-2.5">
                            <span className="sr-only">Close sidebar</span>
                            <XMarkIcon aria-hidden="true" className="size-6 text-white"/>
                        </button>
                    </div>
                </TransitionChild>
                {/* Sidebar component, swap this element with another sidebar if you like */}
                <div
                    className="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4 ring-1 ring-white/10">
                    <div className="flex h-16 shrink-0 items-center">
                        <img
                            alt="Your Company"
                            src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
                            className="h-8 w-auto"
                        />
                    </div>

                    <NavigationItems/>
                </div>
            </DialogPanel>
        </div>
    </Dialog>;
}
