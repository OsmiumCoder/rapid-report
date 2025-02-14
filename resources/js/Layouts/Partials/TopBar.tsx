import { Bars3Icon, BellIcon, UserCircleIcon } from '@heroicons/react/24/outline';
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/react/20/solid';
import { Menu, MenuButton, MenuItem, MenuItems, Transition } from '@headlessui/react';
import { Link, usePage } from '@inertiajs/react';
import { Method } from '@/types/Method';
import { useRef, useState } from 'react';
import Searchbar from '@/Layouts/Partials/Searchbar';
import Notifications from '@/Layouts/Partials/Notifications';
import useDismiss from '@/hooks/useDismiss';
import ConfirmationModal from '@/Components/confirmationModal/ConfirmationModal';
import { useConfirmationModal } from '@/Components/confirmationModal/ConfirmationModalProvider';

const userNavigation: { name: string; href: string; method?: Method }[] = [
    { name: 'Your profile', href: route('profile.edit') },
    { name: 'Sign out', href: route('logout'), method: 'post' },
];

export default function TopBar({ onClick }: { onClick: () => void }) {
    const user = usePage().props.auth.user;

    const { modalRef } = useConfirmationModal();

    const [isSearchOpen, setIsSearchOpen] = useState(false);
    const [isNotificationOpen, setIsNotificationOpen] = useState(false);

    const notificationButtonRef = useRef<HTMLButtonElement>(null);

    const notificationRef = useDismiss<HTMLDivElement>({
        onDismiss: () => setIsNotificationOpen(false),
        ignoreRefs: [notificationButtonRef, modalRef],
    });

    const hasUnreadNotifications =
        usePage().props.notifications?.some(({ read_at }) => read_at === null) ?? false;
    return (
        <>
            <Searchbar isOpen={isSearchOpen} setIsOpen={setIsSearchOpen} />

            <div className="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
                <button
                    type="button"
                    onClick={onClick}
                    className="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                >
                    <span className="sr-only">Open sidebar</span>
                    <Bars3Icon aria-hidden="true" className="size-6" />
                </button>

                {/* Separator */}
                <div aria-hidden="true" className="h-6 w-px bg-gray-900/10 lg:hidden" />

                <div className="flex flex-1 self-stretch justify-end items-center lg:gap-x-6">
                    {(user.roles.some((role) => role.name === 'admin') ||
                        user.roles.some((role) => role.name === 'super-admin')) && (
                        <button
                            type="button"
                            className="text-gray-400 hover:text-gray-500"
                            onClick={() => setIsSearchOpen(true)}
                        >
                            <MagnifyingGlassIcon
                                aria-hidden="true"
                                className="pointer-events-none col-start-1 row-start-1 size-5 self-center"
                            />
                        </button>
                    )}
                    <div className="flex items-center gap-x-4 lg:gap-x-6">
                        <div className="relative flex items-center">
                            <button
                                ref={notificationButtonRef}
                                type="button"
                                className="text-gray-400 hover:text-gray-500"
                                onClick={() => setIsNotificationOpen((prev) => !prev)}
                            >
                                <span className="sr-only">View notifications</span>
                                <BellIcon aria-hidden="true" className="size-6" />
                                {hasUnreadNotifications && (
                                    <span className="absolute top-0 right-0 flex items-center justify-center h-2 w-2 font-semibold text-white bg-red-500 rounded-full" />
                                )}
                            </button>

                            <Transition
                                show={isNotificationOpen}
                                enter="transition-all ease-out duration-300"
                                enterFrom="opacity-0"
                                enterTo="opacity-100"
                                leave="transition-all ease-in duration-200"
                                leaveFrom="opacity-100 "
                                leaveTo="opacity-0"
                            >
                                <div ref={notificationRef}>
                                    <Notifications />
                                </div>
                            </Transition>
                        </div>
                        {/* Separator */}
                        <div
                            aria-hidden="true"
                            className="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-900/10"
                        />

                        {/* Profile dropdown */}
                        <Menu as="div" className="relative">
                            <MenuButton className="-m-1.5 flex items-center p-1.5">
                                <span className="sr-only">Open user menu</span>
                                <UserCircleIcon className="size-8 rounded-full bg-gray-50" />
                                <span className="hidden lg:flex lg:items-center">
                                    <span
                                        aria-hidden="true"
                                        className="ml-4 text-sm/6 font-semibold text-gray-900"
                                    >
                                        {user.name}
                                    </span>
                                    <ChevronDownIcon
                                        aria-hidden="true"
                                        className="ml-2 size-5 text-gray-400"
                                    />
                                </span>
                            </MenuButton>
                            <MenuItems
                                transition
                                className="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 transition focus:outline-none data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-100 data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in"
                            >
                                {userNavigation.map((item) => (
                                    <MenuItem key={item.name}>
                                        <Link
                                            href={item.href}
                                            method={item.method}
                                            className="block px-3 py-1 text-sm/6 text-gray-900 data-[focus]:bg-gray-50 data-[focus]:outline-none"
                                        >
                                            {item.name}
                                        </Link>
                                    </MenuItem>
                                ))}
                            </MenuItems>
                        </Menu>
                    </div>
                </div>
            </div>
        </>
    );
}
