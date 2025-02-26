import { useConfirmationModal } from '@/Components/ConfirmationModal/ConfirmationModalProvider';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { EllipsisVerticalIcon } from '@heroicons/react/20/solid';
import { router } from '@inertiajs/react';

export default function NotificationActions() {
    const { setModalProps } = useConfirmationModal();

    const deleteAllNotifications = () => {
        try {
            router.delete(route('notifications.destroy-all'), {
                onSuccess: () =>
                    router.reload({
                        only: ['notifications', 'notifications_paginator'],
                        reset: ['notifications', 'notifications_paginator'],
                        data: { notifications: 1 },
                    }),
            });
        } catch (error) {
            console.error(error);
        }
    };

    const markAllNotificationsAsRead = async () => {
        try {
            router.put(route('notifications.mark-all-read'), undefined, {
                onSuccess: () =>
                    router.reload({
                        only: ['notifications', 'notifications_paginator'],
                        reset: ['notifications', 'notifications_paginator'],
                        data: { notifications: 1 },
                    }),
            });
        } catch (error) {
            console.error(error);
        }
    };

    return (
        <>
            <Menu as="div" className="relative z-50 inline-block px-2 text-left">
                <div>
                    <MenuButton className="focus:ring-upei-green-500 flex cursor-pointer items-center rounded-full text-gray-400 hover:text-gray-600 focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:outline-hidden">
                        <span className="sr-only">Open options</span>
                        <EllipsisVerticalIcon aria-hidden="true" className="size-5" />
                    </MenuButton>
                </div>

                <MenuItems
                    transition
                    className="absolute right-2 z-10 mt-2 w-32 origin-top-right rounded-lg border border-gray-200 bg-white shadow-lg ring-1 ring-black/5 transition focus:outline-hidden data-[closed]:scale-95 data-[closed]:transform data-[closed]:opacity-0 data-[enter]:duration-100 data-[enter]:ease-out data-[leave]:duration-75 data-[leave]:ease-in"
                >
                    <div className="py-1">
                        <MenuItem>
                            <button
                                onClick={markAllNotificationsAsRead}
                                className="block w-full cursor-pointer px-4 py-2 text-sm text-gray-700 data-[focus]:bg-gray-100 data-[focus]:text-gray-900 data-[focus]:outline-hidden"
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
                                className="block w-full cursor-pointer px-4 py-2 text-sm text-gray-700 data-[focus]:bg-gray-100 data-[focus]:text-gray-900 data-[focus]:outline-hidden"
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
