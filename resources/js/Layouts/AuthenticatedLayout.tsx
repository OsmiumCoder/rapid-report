import { PropsWithChildren, ReactNode, useState } from 'react';
import TopBar from '@/Layouts/Partials/TopBar';
import DesktopSidebar from '@/Layouts/Partials/DesktopSidebar';
import MobileSidebar from '@/Layouts/Partials/MobileSidebar';
import DashboardNavBar, {NavigationItem} from '@/Components/DashboardNavBar';

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
            roles: ['admin', 'super-admin'],
        },
        { name: 'User Management', href: 'dashboard.user-management', roles: ['admin', 'super-admin'] },
    ];
    const reportNav: NavigationItem[] = [
        {
            name: 'Report Builder',
            href: 'report.index',
            roles: ['admin', 'super-admin'],
        },
        {
            name: 'Statistics Portal',
            href: 'report.stats',
            roles: ['admin', 'super-admin'],
        },
    ];
    return (
        <>
            <div>
                <MobileSidebar
                    open={sidebarOpen}
                    onClose={setSidebarOpen}
                    onClick={() => setSidebarOpen(false)}
                />

                <DesktopSidebar />

                <div className="lg:pl-72">
                    <TopBar onClick={() => setSidebarOpen(true)} />

                    {(route().current('dashboard') || route().current('dashboard.*')) && (
                        <DashboardNavBar navigationItems={dashboardNavigationItems} />
                    )}
                    {(route().current('report') || route().current('report.*')) && (
                        <DashboardNavBar navigationItems={reportNav} />
                    )}

                    <main className="py-10 bg-gray-100">
                        <div>{children}</div>
                    </main>
                </div>
            </div>
        </>
    );
}
