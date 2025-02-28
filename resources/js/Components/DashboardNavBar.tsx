import classNames from '@/Formatters/classNames';
import { RoleName } from '@/types';
import { Link, usePage } from '@inertiajs/react';

export interface NavigationItem {
    name: string;
    href: string;
    roles: RoleName[];
}

interface NavProps {
    navigationItems: NavigationItem[];
}
export default function DashboardNavBar({ navigationItems }: NavProps) {
    const { user } = usePage().props.auth;

    return (
        <nav className="flex overflow-x-auto border-b border-gray-200 bg-white">
            <ul role="list" className="flex min-w-full flex-none gap-x-4 px-4 text-sm/6 font-semibold sm:px-6 lg:px-8">
                {navigationItems.map((item, index) => (
                    <>
                        {(user.roles.some(({ name }) => item.roles.includes(name)) || item.roles.includes('all')) && (
                            <Link
                                as="li"
                                href={route(item.href)}
                                key={index}
                                className={classNames(
                                    route().current(item.href) ? 'border-upei-red-500 border-b-2 text-gray-900' : '',
                                    'hover:border-upei-red-400 cursor-pointer border-transparent px-2 py-4 text-gray-600 hover:border-b-2 hover:text-gray-700',
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
