import LoadingIndicator from '@/Components/LoadingIndicator';
import { ChatBubbleBottomCenterTextIcon } from '@heroicons/react/16/solid';
import { PaperClipIcon } from '@heroicons/react/20/solid';
import { PaperAirplaneIcon } from '@heroicons/react/24/solid';
import { FormEvent } from 'react';

interface AddCommentFormProps {
    submit: (e: FormEvent<HTMLFormElement>) => void;
    setData: ((data: { content: string }) => void) &
        ((
            data: (previousData: { content: string }) => {
                content: string;
            },
        ) => void) &
        (<K extends keyof { content: string }>(key: K, value: { content: string }[K]) => void);
    processing: boolean;
    data: { content: string };
}

export default function AddCommentForm({ submit, setData, processing, data }: AddCommentFormProps) {
    return (
        <div className="mt-6 flex gap-x-3">
            <ChatBubbleBottomCenterTextIcon className="relative flex size-6 flex-none items-center justify-center bg-white text-upei-green-600" />

            <form onSubmit={submit} className="relative flex-auto">
                <div className="overflow-hidden rounded-lg pb-12 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-upei-green-600">
                    <label className="sr-only">Add your comment</label>
                    <textarea
                        value={data.content}
                        onChange={(e) => setData('content', e.target.value)}
                        rows={2}
                        placeholder="Add your comment..."
                        className="block w-full resize-none border-none bg-transparent px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-0 focus:outline-0 sm:text-sm/6"
                    />
                </div>

                <div className="absolute inset-x-0 bottom-0 flex justify-between py-2 pr-2 pl-3">
                    <div className="flex items-center space-x-5">
                        <div className="flex items-center">
                            <button
                                type="button"
                                className="-m-2.5 flex size-10 cursor-pointer items-center justify-center rounded-full text-gray-400 hover:text-gray-500"
                            >
                                <PaperClipIcon aria-hidden="true" className="size-5" />
                                <span className="sr-only">Attach a file</span>
                            </button>
                        </div>
                    </div>
                    {!processing ? (
                        <button
                            type="submit"
                            className="-m-2.5 cursor-pointer flex size-10 items-center justify-center rounded-full text-upei-green-600 hover:text-upei-green-500"
                        >
                            <PaperAirplaneIcon className="mr-2 size-7" />
                        </button>
                    ) : (
                        <LoadingIndicator />
                    )}
                </div>
            </form>
        </div>
    );
}
