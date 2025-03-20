import GuestLayout from '@/Layouts/GuestLayout';
import { PencilIcon } from '@heroicons/react/24/outline';
import { Head, Link, useForm } from '@inertiajs/react';
import { FormEventHandler } from 'react';

export default function Login({ status }: { status?: string; canResetPassword: boolean }) {
    const { post, reset } = useForm({
        email: '',
        password: '',
        remember: false as boolean,
    });

    const submit: FormEventHandler = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            {status && <div className="mb-4 text-sm font-medium text-green-600">{status}</div>}

            <form onSubmit={submit}>
                <div className="mt-2 flex justify-center font-semibold">Submit an Incident Without Signing In</div>

                <div className="mt-4 flex justify-center">
                    <Link
                        href={route('incidents.create')}
                        as="button"
                        className="bg-upei-green-500 hover:bg-upei-green-600 focus-visible:outline-upei-green-600 flex cursor-pointer items-center rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        <PencilIcon className="mr-2 h-4 w-4" />
                        Submit Incident
                    </Link>
                </div>

                <div className="relative my-6">
                    <div aria-hidden="true" className="absolute inset-0 flex items-center">
                        <div className="w-full border-t border-gray-300" />
                    </div>
                    <div className="relative flex justify-center">
                        <span className="bg-white px-2 text-sm text-gray-500">Or</span>
                    </div>
                </div>

                <div className="mb-4 flex justify-center">
                    <a
                        href={route('redirect.microsoft')}
                        as="button"
                        className="bg-upei-green-500 hover:bg-upei-green-600 focus-visible:outline-upei-green-600 flex cursor-pointer items-center rounded-md px-3 py-2 text-center text-sm font-semibold text-white shadow-xs focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2"
                    >
                        <span className="flex items-center space-x-5 hover:cursor-pointer">
                            <div className="size-10">
                                <svg viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <rect x="17" y="17" width="10" height="10" fill="#FEBA08"></rect>
                                        <rect x="5" y="17" width="10" height="10" fill="#05A6F0"></rect>
                                        <rect x="17" y="5" width="10" height="10" fill="#80BC06"></rect>
                                        <rect x="5" y="5" width="10" height="10" fill="#F25325"></rect>
                                    </g>
                                </svg>
                            </div>
                            Login with Microsoft
                        </span>
                    </a>
                </div>
            </form>
        </GuestLayout>
    );
}
