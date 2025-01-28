import { Incident } from '@/types/Incident';

export default function AdminActions({ incident }: { incident: Incident }) {
    return (
        <>
            <div className="lg:col-start-3 lg:row-end-1">
                <div className="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
                    <dl className="flex flex-wrap">
                        <div className="flex-auto pl-6 pt-6">
                            <dt className="text-sm/6 font-semibold text-gray-900">
                                Actions for admin
                            </dt>
                            <dd className="mt-1 text-base font-semibold text-gray-900">
                                Actions for admin
                            </dd>
                        </div>
                        <div className="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6">
                            <dt className="flex-none"></dt>
                            <dd className="text-sm/6 font-medium text-gray-900">
                                Actions for admin
                            </dd>
                        </div>
                        <div className="mt-4 flex w-full flex-none gap-x-4 px-6">
                            <dt className="flex-none"></dt>
                            <dd className="text-sm/6 text-gray-500">
                                Actions for admin
                            </dd>
                        </div>
                    </dl>
                    <div className="mt-6 border-t border-gray-900/5 px-6 py-6">
                        <dd className="text-sm/6 font-semibold text-gray-900">
                            Actions for admin
                        </dd>
                    </div>
                </div>
            </div>
        </>
    );
}
