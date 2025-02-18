import { Link, usePage } from '@inertiajs/react';
import classNames from '@/Filters/classNames';
import { RoleName } from '@/types';

interface NavigationItem {
    name: string;
    href: string;
    roles: RoleName[];
}

const navigationItems: NavigationItem[] = [
    { name: 'Dashboard', href: 'dashboard', roles: ['all'] },
    {
        name: 'Supervisor Overview',
        href: 'dashboard.supervisor',
        roles: ['supervisor'],
    },
    {
        name: 'Admin Overview',
        href: 'dashboard.admin',
        roles: ['admin', 'super-admin'],
    },
    { name: 'User Management', href: 'dashboard.user-management', roles: ['admin', 'super-admin'] },
];

export default function DashboardNavBar() {
    const { user } = usePage().props.auth;

    return (
        <nav className="flex overflow-x-auto border-b border-gray-200 bg-white">
            <ul
                role="list"
                className="flex min-w-full flex-none gap-x-4 px-4 text-sm/6 font-semibold sm:px-6 lg:px-8"
            >
                {navigationItems.map((item, index) => (
                    <>
                        {(user.roles.some(({ name }) => item.roles.includes(name)) ||
                            item.roles.includes('all')) && (
                            <Link
                                as="li"
                                href={route(item.href)}
                                key={index}
                                className={classNames(
                                    route().current(item.href)
                                        ? 'border-b-2 border-upei-red-500 text-gray-900'
                                        : '',
                                    'border-transparent text-gray-600 hover:border-b-2 hover:border-upei-red-400 hover:text-gray-700 py-4 px-2 cursor-pointer'
                                )}
                            >
                                {item.name}
                            </Link>
                        )}
                    </>
                ))}
            </ul>
        </nav>
    );
}
