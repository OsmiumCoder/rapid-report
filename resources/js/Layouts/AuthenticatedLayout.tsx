import { PropsWithChildren, ReactNode, useState } from 'react';
import TopBar from '@/Layouts/Partials/TopBar';
import DesktopSidebar from '@/Layouts/Partials/DesktopSidebar';
import MobileSidebar from '@/Layouts/Partials/MobileSidebar';

export default function Authenticated({
    children,
}: PropsWithChildren<{ header?: ReactNode }>) {
    const [sidebarOpen, setSidebarOpen] = useState(false);

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

                    <main className="py-10 bg-gray-100">
                        <div>{children}</div>
                    </main>
                </div>
            </div>
        </>
    );
}
