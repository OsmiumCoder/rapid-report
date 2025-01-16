import classNames from '@/Filters/classNames'
import { ChevronDownIcon, ChevronUpIcon } from '@heroicons/react/24/outline'
import { NavigationItemInterface } from '@/Layouts/Partials/NavigationItem'
import { useState } from 'react'

interface NavigationDropDownItemProps {
    item: NavigationItemInterface
    isOpen: boolean
    onClick: () => void
}

export default function NavigationDropDownItem({
    item,
    isOpen,
    onClick,
}: NavigationDropDownItemProps) {
    return (
        <div
            className={classNames(
                'flex flex-row group gap-x-3 text-gray-400 hover:bg-gray-800',
                'hover:text-white rounded-md',
                'p-2 text-sm/6 font-semibold'
            )}
            onClick={onClick}
        >
            {item.icon && (
                <item.icon aria-hidden="true" className="size-6 shrink-0" />
            )}
            {item.name}
            {isOpen ? (
                <ChevronDownIcon
                    aria-hidden="true"
                    className="size-6 shrink-0 text-white"
                />
            ) : (
                <ChevronUpIcon
                    aria-hidden="true"
                    className="size-6 shrink-0 text-white"
                />
            )}
        </div>
    )
}
