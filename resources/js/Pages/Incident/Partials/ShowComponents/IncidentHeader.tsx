import ApplicationLogo from '@/Components/ApplicationLogo';
import PrimaryButton from '@/Components/PrimaryButton';
import { Incident } from '@/types/incident/Incident';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/react';
import { EllipsisVerticalIcon } from '@heroicons/react/20/solid';

export default function IncidentHeader({ incident }: { incident: Incident }) {
    return (
        <>
            <header className="relative isolate">
                <div className="mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="mx-auto flex max-w-2xl items-center justify-between gap-x-8 lg:mx-0 lg:max-w-none">
                        <div className="flex items-center gap-x-6">
                            <ApplicationLogo className="size-[6rem] flex-none rounded-full ring-gray-900/10" />
                            <h1>
                                <div className="text-sm/6 text-gray-500">
                                    Incident <span className="text-gray-700">{incident.slug}</span>
                                </div>
                                <div className="mt-1 text-base font-semibold text-gray-900">UPEI Health & Safety</div>
                            </h1>
                        </div>
                    </div>
                </div>
            </header>
        </>
    );
}
