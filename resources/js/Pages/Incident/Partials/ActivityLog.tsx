import { useState } from 'react';
import {
    Label,
    Listbox,
    ListboxButton,
    ListboxOption,
    ListboxOptions,
} from '@headlessui/react';
import {
    FaceFrownIcon,
    FaceSmileIcon,
    FireIcon,
    HandThumbUpIcon,
    HeartIcon,
    PaperClipIcon,
    XMarkIcon as XMarkIconMini,
} from '@heroicons/react/20/solid';
import { CheckCircleIcon } from '@heroicons/react/24/solid';
import classNames from '@/Filters/classNames';
import { Incident } from '@/types/Incident';
import {ChatBubbleBottomCenterTextIcon} from "@heroicons/react/16/solid";

const activity = [
    {
        id: 1,
        type: 'created',
        person: { name: 'Chelsea Hagon' },
        date: '7d ago',
        dateTime: '2023-01-23T10:32',
    },
    {
        id: 2,
        type: 'edited',
        person: { name: 'Chelsea Hagon' },
        date: '6d ago',
        dateTime: '2023-01-23T11:03',
    },
    {
        id: 3,
        type: 'sent',
        person: { name: 'Chelsea Hagon' },
        date: '6d ago',
        dateTime: '2023-01-23T11:24',
    },
    {
        id: 4,
        type: 'commented',
        person: {
            name: 'Chelsea Hagon',
            imageUrl:
                'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        comment:
            'Called client, they reassured me the invoice would be paid by the 25th.',
        date: '3d ago',
        dateTime: '2023-01-23T15:56',
    },
    {
        id: 5,
        type: 'viewed',
        person: { name: 'Alex Curren' },
        date: '2d ago',
        dateTime: '2023-01-24T09:12',
    },
    {
        id: 6,
        type: 'paid',
        person: { name: 'Alex Curren' },
        date: '1d ago',
        dateTime: '2023-01-24T09:20',
    },
];

export default function ActivityLog({ comments }: { comments: Comment[] }) {

    return (
        <>
            <div className="lg:col-start-3 p-5 rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5">
                <h2 className="text-sm/6 font-semibold text-gray-900">
                    Activity
                </h2>
                <ul role="list" className="mt-6 space-y-6">
                    {activity.map((activityItem, activityItemIdx) => (
                        <li
                            key={activityItem.id}
                            className="relative flex gap-x-4"
                        >
                            <div
                                className={classNames(
                                    activityItemIdx === activity.length - 1
                                        ? 'h-6'
                                        : '-bottom-6',
                                    'absolute left-0 top-0 flex w-6 justify-center'
                                )}
                            >
                                <div className="w-px bg-gray-200" />
                            </div>
                            {activityItem.type === 'commented' ? (
                                <>
                                    <ChatBubbleBottomCenterTextIcon className="text-blue-600 relative flex size-6 flex-none items-center justify-center bg-white"/>

                                    <div className="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                                        <div className="flex justify-between gap-x-4">
                                            <div className="py-0.5 text-xs/5 text-gray-500">
                                                <span className="font-medium text-gray-900">
                                                    {activityItem.person.name}
                                                </span>{' '}
                                                commented
                                            </div>
                                            <time
                                                dateTime={activityItem.dateTime}
                                                className="flex-none py-0.5 text-xs/5 text-gray-500"
                                            >
                                                {activityItem.date}
                                            </time>
                                        </div>
                                        <p className="text-sm/6 text-gray-500">
                                            {activityItem.comment}
                                        </p>
                                    </div>
                                </>
                            ) : (
                                <>
                                    <div className="relative flex size-6 flex-none items-center justify-center bg-white">
                                        {activityItem.type === 'paid' ? (
                                            <CheckCircleIcon
                                                aria-hidden="true"
                                                className="size-6 text-indigo-600"
                                            />
                                        ) : (
                                            <div className="size-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                                        )}
                                    </div>
                                    <p className="flex-auto py-0.5 text-xs/5 text-gray-500">
                                        <span className="font-medium text-gray-900">
                                            {activityItem.person.name}
                                        </span>{' '}
                                        {activityItem.type} the invoice.
                                    </p>
                                    <time
                                        dateTime={activityItem.dateTime}
                                        className="flex-none py-0.5 text-xs/5 text-gray-500"
                                    >
                                        {activityItem.date}
                                    </time>
                                </>
                            )}
                        </li>
                    ))}
                </ul>

                {/* New comment form */}
                <div className="mt-6 flex gap-x-3">
                    <img
                        alt=""
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        className="size-6 flex-none rounded-full bg-gray-50"
                    />
                    <form action="#" className="relative flex-auto">
                        <div className="overflow-hidden rounded-lg pb-12 outline outline-1 -outline-offset-1 outline-gray-300 focus-within:outline focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                            <label htmlFor="comment" className="sr-only">
                                Add your comment
                            </label>
                            <textarea
                                id="comment"
                                name="comment"
                                rows={2}
                                placeholder="Add your comment..."
                                className="block w-full resize-none bg-transparent px-3 py-1.5 text-base text-gray-900 border-0 placeholder:text-gray-400 focus:outline focus:outline-0 sm:text-sm/6"
                                defaultValue={''}
                            />
                        </div>

                        <div className="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                            <div className="flex items-center space-x-5">
                                <div className="flex items-center">
                                    <button
                                        type="button"
                                        className="-m-2.5 flex size-10 items-center justify-center rounded-full text-gray-400 hover:text-gray-500"
                                    >
                                        <PaperClipIcon
                                            aria-hidden="true"
                                            className="size-5"
                                        />
                                        <span className="sr-only">
                                            Attach a file
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <button
                                type="submit"
                                className="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                Comment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </>
    );
}
