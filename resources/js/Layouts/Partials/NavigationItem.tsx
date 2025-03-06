import classNames from '@/Formatters/classNames';
import { RoleName } from '@/types';
import { Link } from '@inertiajs/react';
import { ComponentType, SVGProps } from 'react';

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
                    route().current(item.route + '*') ? 'bg-upei-red-700 text-white' : 'hover:bg-upei-red-700 text-gray-300 hover:text-white',
                    'group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold',
                )}
            >
                {item.icon && <item.icon aria-hidden="true" className="size-6 shrink-0" />}
                <span className="ml-8">{item.name}</span>
            </Link>
        </li>
    );
}
