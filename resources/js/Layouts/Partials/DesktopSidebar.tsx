import NavigationItems from '@/Layouts/Partials/NavigationItems'
import { usePage } from '@inertiajs/react'

export default function DesktopSidebar() {
    return (
        <>
            {/* Static sidebar for desktop */}
            <div className="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                {/* Sidebar component, swap this element with another sidebar if you like */}
                <div className="flex grow flex-col gap-y-5 overflow-y-auto bg-gray-900 px-6 pb-4">
                    <div className="flex h-16 shrink-0 items-center">
                        <img
                            alt="Your Company"
                            src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
                            className="h-8 w-auto"
                        />
                    </div>

                    <NavigationItems />
                </div>
            </div>
        </>
    )
}
