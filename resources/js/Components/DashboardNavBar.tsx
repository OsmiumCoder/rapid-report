import { Link } from '@inertiajs/react';
import classNames from "@/Filters/classNames";

const navigationItems = [
    { name: 'Dashboard', href: '#', current: true },
    { name: 'User Management', href: '#', current: false },
];

export default function DashboardNavBar() {
    return (
        <nav className="flex overflow-x-auto border-b border-gray-200 bg-white">
            <ul
                role="list"
                className="flex min-w-full flex-none gap-x-4 px-4 text-sm/6 font-semibold sm:px-6 lg:px-8"
            >
                {navigationItems.map((item, index) => (
                    <li key={index} className={classNames(
                       item.current ? 'border-b-2 border-indigo-500 text-gray-900' : '',
                        'border-transparent text-gray-600 hover:border-gray-500 hover:text-gray-700 py-4 px-2'
                    )}>
                        <Link href={item.href}>
                            {item.name}
                        </Link>
                    </li>
                ))}
            </ul>
        </nav>
    );
}
