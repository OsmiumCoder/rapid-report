import DashboardNavBar, { NavigationItem } from '@/Components/DashboardNavBar';
import DesktopSidebar from '@/Layouts/Partials/DesktopSidebar';
import MobileSidebar from '@/Layouts/Partials/MobileSidebar';
import TopBar from '@/Layouts/Partials/TopBar';
import { PropsWithChildren, ReactNode, useState } from 'react';

export default function Authenticated({ children }: PropsWithChildren<{ header?: ReactNode }>) {
    const [sidebarOpen, setSidebarOpen] = useState(false);
    const dashboardNavigationItems: NavigationItem[] = [
        { name: 'Dashboard', href: 'dashboard', roles: ['all'] },
        {
            name: 'Supervisor Overview',
            href: 'dashboard.supervisor',
            roles: ['supervisor'],
        },
        {
            name: 'Admin Overview',
            href: 'dashboard.admin',
            roles: ['admin'],
        },
        { name: 'User Management', href: 'dashboard.user-management', roles: ['admin'] },
        { name: 'Settings', href: 'dashboard.settings', roles: ['admin'] },
    ];
    const reportNav: NavigationItem[] = [
        {
            name: 'Report Builder',
            href: 'report.index',
            roles: ['admin'],
        },
        {
            name: 'Statistics Portal',
            href: 'report.stats',
            roles: ['admin'],
        },
    ];
    return (
        <>
            <div>
                <MobileSidebar open={sidebarOpen} onClose={setSidebarOpen} onClick={() => setSidebarOpen(false)} />

                <DesktopSidebar />

                <div className="lg:pl-72">
                    <TopBar onClick={() => setSidebarOpen(true)} />

                    {(route().current('dashboard') || route().current('dashboard.*')) && (
                        <DashboardNavBar navigationItems={dashboardNavigationItems} />
                    )}
                    {(route().current('report') || route().current('report.*')) && <DashboardNavBar navigationItems={reportNav} />}

                    <main className="bg-gray-100 py-10">
                        <div>{children}</div>
                    </main>
                </div>
            </div>
        </>
    );
}
