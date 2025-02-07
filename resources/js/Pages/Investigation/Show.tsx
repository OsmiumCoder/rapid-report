import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import { PageProps, User } from '@/types';
import InvestigationAdminActions from '@/Pages/Investigation/Partials/ShowComponents/InvestigationAdminActions';
import { Investigation } from '@/types/Investigation/Investigation';
import InvestigationInformationPanel from '@/Pages/Investigation/Partials/ShowComponents/InvestigationInformationPanel';

interface ShowProps extends PageProps {
    investigation: Investigation;
}

export default function Show({ investigation }: PageProps<ShowProps>) {
    return (
        <AuthenticatedLayout>
            <Head title="Investigation" />
            <>
                <main>
                    <div className="mx-auto px-4 py-10 sm:px-6 lg:px-8">
                        <div className="mx-auto grid max-w-2xl grid-cols-1 grid-rows-1 items-start gap-x-8 gap-y-8 lg:mx-0 lg:max-w-none lg:grid-cols-3">
                            <InvestigationAdminActions investigation={investigation} />
                            <InvestigationInformationPanel investigation={investigation} />
                        </div>
                    </div>
                </main>
            </>
        </AuthenticatedLayout>
    );
}
