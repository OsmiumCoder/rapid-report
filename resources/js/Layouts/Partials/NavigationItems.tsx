import {Link} from "@inertiajs/react";
import {Cog6ToothIcon, FolderIcon, HomeIcon} from "@heroicons/react/24/outline";
import classNames from "@/Filters/classNames";

const navigationItems = [
    {
        name: 'Dashboard',
        href: route('dashboard'),
        icon: HomeIcon,
        current: route().current('dashboard')
    },
    {
        name: 'Incidents',
        href: route('incidents.index'),
        icon: FolderIcon,
        current: route().current('incidents.*')
    },
]

export default function NavigationItems() {
    return (
        <nav className="flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" className="-mx-2 space-y-1">
                        {navigationItems.map((item, index) => (
                            <li key={index}>
                                <Link
                                    href={item.href}
                                    className={classNames(
                                        item.current
                                            ? 'bg-gray-800 text-white'
                                            : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                                        'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                    )}
                                >
                                    <item.icon aria-hidden="true" className="size-6 shrink-0"/>
                                    {item.name}
                                </Link>
                            </li>
                        ))}
                    </ul>
                </li>

                <li className="mt-auto">
                    <Link
                        href="#"
                        className="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-400 hover:bg-gray-800 hover:text-white"
                    >
                        <Cog6ToothIcon aria-hidden="true" className="size-6 shrink-0"/>
                        Settings
                    </Link>
                </li>
            </ul>
        </nav>
    );
}
