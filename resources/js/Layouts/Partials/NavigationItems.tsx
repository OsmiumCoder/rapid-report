import { Link, usePage } from '@inertiajs/react'
import {
    Cog6ToothIcon,
    FolderIcon,
    HomeIcon,
} from '@heroicons/react/24/outline'
import classNames from '@/Filters/classNames'
import { useState } from 'react'
import NavigationItem, {
    INavigationItem,
} from '@/Layouts/Partials/NavigationItem'
import NavigationDropDownItem from '@/Layouts/Partials/NavigationDropDownItem'

const navigationItems: INavigationItem[] = [
    {
        name: 'Dashboard',
        route: 'dashboard',
        icon: HomeIcon,
        roles: ['all'],
    },
    {
        name: 'Incidents',
        icon: FolderIcon,
        roles: ['all'],
        subItems: [
            {
                name: 'All',
                route: 'incidents.index',
                roles: ['super-admin', 'admin'],
            },
            {
                name: 'Owned',
                route: 'incidents.owned',
                roles: ['all'],
            },
            {
                name: 'Assigned',
                route: 'incidents.assigned',
                roles: ['super-admin', 'admin', 'supervisor'],
            },
        ],
    },
]

export default function NavigationItems() {
    const [incidentDropDownIsOpen, setIncidentDropDownIsOpen] = useState(true)

    return (
        <nav className="flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" className="-mx-2 space-y-1">
                        {navigationItems.map((item, index) => (
                            <>
                                {item.subItems ? (
                                    <div>
                                        <NavigationDropDownItem
                                            item={item}
                                            isOpen={incidentDropDownIsOpen}
                                            onClick={() =>
                                                setIncidentDropDownIsOpen(
                                                    (prev) => !prev
                                                )
                                            }
                                        />
                                        {incidentDropDownIsOpen && (
                                            <div>
                                                {item.subItems.map(
                                                    (item, index) => (
                                                        <NavigationItem
                                                            key={`${item.name}${index}`}
                                                            item={item}
                                                        />
                                                    )
                                                )}
                                            </div>
                                        )}
                                    </div>
                                ) : (
                                    <li key={`${item.name}${index}`}>
                                        <Link
                                            href={route(item.route as string)}
                                            className={classNames(
                                                route().current(
                                                    item.route as string
                                                )
                                                    ? 'bg-gray-800 text-white'
                                                    : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                                                'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold'
                                            )}
                                        >
                                            {item.icon && (
                                                <item.icon
                                                    aria-hidden="true"
                                                    className="size-6 shrink-0"
                                                />
                                            )}
                                            {item.name}
                                        </Link>
                                    </li>
                                )}
                            </>
                        ))}
                    </ul>
                </li>

                <li className="mt-auto">
                    <Link
                        href="#"
                        className={classNames(
                            'group -mx-2 flex gap-x-3 rounded-md',
                            'p-2 text-sm/6 font-semibold text-gray-400',
                            'hover:bg-gray-800 hover:text-white'
                        )}
                    >
                        <Cog6ToothIcon
                            aria-hidden="true"
                            className="size-6 shrink-0"
                        />
                        Settings
                    </Link>
                </li>
            </ul>
        </nav>
    )
}
