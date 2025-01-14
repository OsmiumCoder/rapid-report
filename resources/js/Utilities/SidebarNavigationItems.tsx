import {
    CalendarIcon,
    ChartPieIcon,
    DocumentDuplicateIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon
} from "@heroicons/react/24/outline";
import {useRef} from "react";

export default function SidebarNavigationItems() {
    return [
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
}
