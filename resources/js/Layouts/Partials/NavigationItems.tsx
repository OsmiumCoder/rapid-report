import { Link, usePage } from '@inertiajs/react';
import { FolderIcon, HomeIcon } from '@heroicons/react/24/outline';
import classNames from '@/Filters/classNames';
import { useState } from 'react';
import NavigationItem, { NavigationItemInterface } from '@/Layouts/Partials/NavigationItem';
import NavigationDropDownItem from '@/Layouts/Partials/NavigationDropDownItem';
import { Role } from '@/types';

const navigationItems: NavigationItemInterface[] = [
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
                roles: ['supervisor'],
            },
        ],
    },
];

export default function NavigationItems() {
    const [incidentDropDownIsOpen, setIncidentDropDownIsOpen] = useState(
        route().current('incidents.*')
    );
    const { auth } = usePage().props;

    const canView = (navigationItem: NavigationItemInterface, userRoles: Role[]): boolean =>
        userRoles.some(({ name }) => navigationItem.roles.includes(name)) ||
        navigationItem.roles.includes('all');

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
                                                setIncidentDropDownIsOpen((prev) => !prev)
                                            }
                                        />
                                        {incidentDropDownIsOpen && (
                                            <div>
                                                {item.subItems.map(
                                                    (item, index) =>
                                                        canView(item, auth.user.roles) && (
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
                                    canView(item, auth.user.roles) && (
                                        <li key={`${item.name}${index}`}>
                                            <Link
                                                href={route(item.route as string)}
                                                className={classNames(
                                                    route().current(item.route + '*')
                                                        ? 'bg-upei-red-700 text-white'
                                                        : 'text-gray-200 hover:bg-upei-red-700 hover:text-white',
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
                                    )
                                )}
                            </>
                        ))}
                    </ul>
                </li>
            </ul>
        </nav>
    );
}
