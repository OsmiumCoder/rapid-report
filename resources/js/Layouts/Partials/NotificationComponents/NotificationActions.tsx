import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { EllipsisVerticalIcon } from '@heroicons/react/20/solid';
import { router } from '@inertiajs/react';
import { useConfirmationModal } from '@/Components/confirmationModal/ConfirmationModalProvider';

export default function NotificationActions() {
    const { setModalProps } = useConfirmationModal();

    const deleteAllNotifications = () => {
        try {
            router.delete(route('notifications.destroy-all'), {
                onSuccess: () =>
                    router.reload({ only: ['notifications, notifications_paginator'] }),
            });
        } catch (error) {
            console.error(error);
        }
    };

    const markAllNotificationsAsRead = async () => {
        try {
            router.put(route('notifications.mark-all-read'), undefined, {
                onSuccess: () =>
                    router.reload({ only: ['notifications, notifications_paginator'] }),
            });
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <>
            <Menu as="div" className="relative px-2 inline-block text-left z-50">
                <div>
                    <MenuButton className="flex items-center rounded-full text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-upei-green-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                        <span className="sr-only">Open options</span>
                        <EllipsisVerticalIcon aria-hidden="true" className="size-5" />
                    </MenuButton>
                </div>

                <MenuItems
                    transition
                    className="absolute right-2 z-10 border border-gray-200 rounded-lg mt-2 w-24 sm:w-56 origin-top-right bg-white shadow-lg ring-1 ring-black/5 transition focus:outline-none data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-100 data-[leave]:duration-75 data-[enter]:ease-out data-[leave]:ease-in"
                >
                    <div className="py-1">
                        <MenuItem>
                            <button
                                onClick={markAllNotificationsAsRead}
                                className="block w-full px-4 py-2 text-sm text-gray-700 data-[focus]:bg-gray-100 data-[focus]:text-gray-900 data-[focus]:outline-none"
                            >
                                Mark All Read
                            </button>
                        </MenuItem>
                        <MenuItem>
                            <button
                                onClick={() =>
                                    setModalProps({
                                        title: 'Clear Notifications',
                                        text: "Are you sure you want to clear all your notifications? This can't be undone",
                                        action: deleteAllNotifications,
                                        show: true,
                                    })
                                }
                                className="block w-full px-4 py-2 text-sm text-gray-700 data-[focus]:bg-gray-100 data-[focus]:text-gray-900 data-[focus]:outline-none"
                            >
                                Clear All
                            </button>
                        </MenuItem>
                    </div>
                </MenuItems>
            </Menu>
        </>
    );
}
