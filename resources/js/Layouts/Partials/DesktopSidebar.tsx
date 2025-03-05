import ApplicationLogo from '@/Components/ApplicationLogo';
import NavigationItems from '@/Layouts/Partials/NavigationItems';
import { Link } from '@inertiajs/react';

export default function DesktopSidebar() {
    return (
        <>
            <div className="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <div className="bg-upei-red-500 flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4">
                    <div className="flex items-center justify-center">
                        <Link as="div" className="w-[50%]" href={route('dashboard')}>
                            {' '}
                            <ApplicationLogo />{' '}
                        </Link>
                    </div>

                    <NavigationItems />
                </div>
            </div>
        </>
    );
}
