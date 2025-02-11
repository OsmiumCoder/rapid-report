import { ComponentType, SVGProps } from 'react';
import { Link } from '@inertiajs/react';
import classNames from '@/Filters/classNames';
import { RoleName } from '@/types';

export interface NavigationItemInterface {
    name: string;
    route?: string;
    icon?: ComponentType<SVGProps<SVGSVGElement>>;
    roles: RoleName[];
    subItems?: NavigationItemInterface[];
}

export default function NavigationItem({ item }: { item: NavigationItemInterface }) {
    return (
        <li className="my-1">
            <Link
                href={route(item.route as string)}
                className={classNames(
                    route().current(item.route as string)
                        ? 'bg-upei-red-700 text-white'
                        : 'text-gray-300 hover:bg-upei-red-700 hover:text-white',
                    'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold'
                )}
            >
                {item.icon && <item.icon aria-hidden="true" className="size-6 shrink-0" />}
                <span className="ml-8">{item.name}</span>
            </Link>
        </li>
    );
}
