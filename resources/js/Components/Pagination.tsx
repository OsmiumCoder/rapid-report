import { Link } from '@inertiajs/react';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/react/20/solid';
import { PaginatedResponse } from '@/types/PaginatedResponse';

interface PaginationProps {
    pagination: PaginatedResponse<any>;
}

export default function Pagination({ pagination }: PaginationProps) {
    return (
        <div className="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 md:px-6">
            <div className="flex flex-1 justify-between sm:hidden">
                <Link
                    href={pagination.prev_page_url || '#'}
                    className={`relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 ${
                        !pagination.prev_page_url ? 'cursor-not-allowed opacity-50' : ''
                    }`}
                >
                    Previous
                </Link>
                <Link
                    href={pagination.next_page_url || '#'}
                    className={`relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 ${
                        !pagination.next_page_url ? 'cursor-not-allowed opacity-50' : ''
                    }`}
                >
                    Next
                </Link>
            </div>
            <div className="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
                <div>
                    <p className="text-sm text-gray-700">
                        Showing <span className="font-medium">{pagination.from}</span> to{' '}
                        <span className="font-medium">{pagination.to}</span> of{' '}
                        <span className="font-medium">{pagination.total}</span> results
                    </p>
                </div>
                <div>
                    <nav
                        aria-label="Pagination"
                        className="isolate inline-flex -space-x-px rounded-md shadow-sm"
                    >
                        <Link
                            href={pagination.prev_page_url || '#'}
                            className={`relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 ${
                                !pagination.prev_page_url ? 'cursor-not-allowed opacity-50' : ''
                            }`}
                        >
                            <ChevronLeftIcon className="h-5 w-5" aria-hidden="true" />
                        </Link>

                        {pagination.links.map((link, index) =>
                            isNaN(Number(link.label)) ? null : (
                                <Link
                                    key={index}
                                    href={link.url || '#'}
                                    className={`relative inline-flex items-center px-4 py-2 text-sm font-semibold ${
                                        link.active
                                            ? 'z-10 bg-upei-green-500 text-white focus:z-20 focus:outline-offset-0'
                                            : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0'
                                    }`}
                                    preserveState={true}
                                >
                                    {link.label}
                                </Link>
                            )
                        )}
                        <Link
                            href={pagination.next_page_url || '#'}
                            className={`relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 ${
                                !pagination.next_page_url ? 'cursor-not-allowed opacity-50' : ''
                            }`}
                        >
                            <ChevronRightIcon className="h-5 w-5" aria-hidden="true" />
                        </Link>
                    </nav>
                </div>
            </div>
        </div>
    );
}
