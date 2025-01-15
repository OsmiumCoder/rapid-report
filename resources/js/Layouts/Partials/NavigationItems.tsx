import {Link} from "@inertiajs/react";
import {Cog6ToothIcon, FolderIcon, HomeIcon, ChevronUpIcon, ChevronDownIcon} from "@heroicons/react/24/outline";
import classNames from "@/Filters/classNames";
import {ComponentType, SVGProps, useState} from "react";

interface NavigationItem {
    name: string,
    route?: string,
    icon?: ComponentType<SVGProps<SVGSVGElement>>,
    children?: NavigationItem[]
}

const navigationItems: NavigationItem[] = [
    {
        name: 'Dashboard',
        route: 'dashboard',
        icon: HomeIcon,
    },
    {
        name: 'Incidents',
        icon: FolderIcon,
        children: [
            {
                name: "All",
                route: 'incidents.index',
            },
            {
                name: 'Owned',
                route: 'incidents.owned',
            },
            {
                name: 'Assigned',
                route: 'incidents.assigned',
            }
        ]
    }
    ]

export default function NavigationItems() {
    const [incidentDropDownIsOpen, setIncidentDropDownIsOpen] = useState(true);

    return (
        <nav className="flex flex-1 flex-col">
            <ul role="list" className="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" className="-mx-2 space-y-1">
                        {navigationItems.map((item, index) => (
                            <>
                                {item.children ?
                                    <div>
                                        <div
                                            className={'flex flex-row group gap-x-3 text-gray-400 hover:bg-gray-800 hover:text-white  rounded-md p-2 text-sm/6 font-semibold'}
                                            onClick={() => setIncidentDropDownIsOpen((prev) => !prev)}
                                        >
                                            {item.icon && <item.icon aria-hidden="true" className="size-6 shrink-0"/> }
                                            Incidents
                                            {
                                                incidentDropDownIsOpen ?
                                                    <ChevronDownIcon aria-hidden="true"
                                                                     className="size-6 shrink-0 text-white"/> :
                                                    <ChevronUpIcon aria-hidden="true"
                                                                   className="size-6 shrink-0 text-white"/>
                                            }
                                        </div>
                                        { incidentDropDownIsOpen &&
                                            <div>
                                                {item.children.map((item, index) => (
                                                    <li key={`${item.name}${index}`} className='my-1'>
                                                        <Link
                                                            href={route(item.route as string)}
                                                            className={classNames(
                                                                route().current(item.route as string)
                                                                    ? 'bg-gray-800 text-white'
                                                                    : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                                                                'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                                            )}
                                                        >
                                                            {item.icon && <item.icon aria-hidden="true" className="size-6 shrink-0"/> }
                                                            <span className='ml-8'>{item.name}</span>
                                                        </Link>
                                                    </li>
                                                ))}
                                            </div>
                                        }
                                    </div>
                                    : (
                                        <li key={`${item.name}${index}`}>
                                            <Link
                                                href={route(item.route as string)}
                                                className={classNames(
                                                    route().current(item.route as string)
                                                        ? 'bg-gray-800 text-white'
                                                        : 'text-gray-400 hover:bg-gray-800 hover:text-white',
                                                    'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                                                )}
                                            >
                                                {item.icon && <item.icon aria-hidden="true" className="size-6 shrink-0"/> }
                                                {item.name}
                                            </Link>
                                        </li>
                                    )
                                }
                            </>
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
