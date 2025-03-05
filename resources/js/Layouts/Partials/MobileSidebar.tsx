import { Dialog, DialogBackdrop, DialogPanel, TransitionChild } from '@headlessui/react';
import { XMarkIcon } from '@heroicons/react/24/outline';

import ApplicationLogo from '@/Components/ApplicationLogo';
import NavigationItems from '@/Layouts/Partials/NavigationItems';
import {Link} from "@inertiajs/react";

export default function MobileSidebar(props: {
    open: boolean;
    onClose: (value: ((prevState: boolean) => boolean) | boolean) => void;
    onClick: () => void;
}) {
    return (
        <Dialog open={props.open} onClose={props.onClose} className="relative z-50 lg:hidden">
            <DialogBackdrop
                transition
                className="bg-upei-red-800/80 fixed inset-0 transition-opacity duration-300 ease-linear data-[closed]:opacity-0"
            />

            <div className="fixed inset-0 flex">
                <DialogPanel
                    transition
                    className="relative mr-16 flex w-full max-w-xs flex-1 transform transition duration-300 ease-in-out data-[closed]:-translate-x-full"
                >
                    <TransitionChild>
                        <div className="absolute top-0 left-full flex w-16 justify-center pt-5 duration-300 ease-in-out data-[closed]:opacity-0">
                            <button type="button" onClick={props.onClick} className="-m-2.5 p-2.5">
                                <span className="sr-only">Close sidebar</span>
                                <XMarkIcon aria-hidden="true" className="size-6 text-white" />
                            </button>
                        </div>
                    </TransitionChild>
                    {/* Sidebar component, swap this element with another sidebar if you like */}
                    <div className="bg-upei-red-500 flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4 ring-1 ring-white/10">
                        <div className="flex items-center justify-center">
                            <Link className="w-[40%]" href={route('dashboard')}><ApplicationLogo/></Link>
                        </div>
                        <NavigationItems />
                    </div>
                </DialogPanel>
            </div>
        </Dialog>
    );
}
