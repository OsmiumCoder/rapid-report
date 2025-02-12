import NavigationItems from '@/Layouts/Partials/NavigationItems';
import { usePage } from '@inertiajs/react';
import ApplicationLogo from '@/Components/ApplicationLogo';

export default function DesktopSidebar() {
    return (
        <>
            <div className="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <div className="flex grow flex-col gap-y-5 overflow-y-auto bg-upei-red-500 px-6 pb-4">
                    <div className="flex items-center justify-center">
                        <ApplicationLogo className="w-[50%]" />
                    </div>

                    <NavigationItems />
                </div>
            </div>
        </>
    );
}
