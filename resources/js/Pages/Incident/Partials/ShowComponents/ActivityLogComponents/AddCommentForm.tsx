import LoadingIndicator from '@/Components/LoadingIndicator';
import { ChatBubbleBottomCenterTextIcon } from '@heroicons/react/16/solid';
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
            <ChatBubbleBottomCenterTextIcon className="text-upei-green-600 relative flex size-6 flex-none items-center justify-center bg-white" />

            <form onSubmit={submit} className="relative flex-auto">
                <div className="focus-within:outline-upei-green-600 overflow-hidden rounded-lg pb-12 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2">
                    <label className="sr-only">Add your comment</label>
                    <textarea
                        value={data.content}
                        onChange={(e) => setData('content', e.target.value)}
                        rows={2}
                        placeholder="Add your comment..."
                        className="block w-full resize-none border-none bg-transparent px-3 py-1.5 text-base text-gray-900 placeholder:text-gray-400 focus:ring-0 focus:outline-0 sm:text-sm/6"
                    />
                </div>

                <div className="absolute inset-x-0 bottom-0 flex justify-end py-2 pr-2 pl-3">
                    {!processing ? (
                        <button
                            type="submit"
                            className="text-upei-green-600 hover:text-upei-green-500 -m-2.5 flex size-10 cursor-pointer items-center justify-center rounded-full"
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
