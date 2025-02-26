import timeSince from '@/Filters/timeSince';
import { Comment } from '@/types/Comment';
import { ChatBubbleBottomCenterTextIcon } from '@heroicons/react/20/solid';

export default function NoteComment({ comment }: { comment: Comment }) {
    return (
        <>
            <ChatBubbleBottomCenterTextIcon className="relative flex size-6 flex-none items-center justify-center bg-white text-upei-green-600" />

            <div className="flex-auto rounded-md p-3 ring-1 ring-gray-200 ring-inset">
                <div className="flex justify-between gap-x-4">
                    <div className="py-0.5 text-xs/5 text-gray-500">
                        <div>
                            <span className="font-medium text-gray-900">{comment.user?.name ?? 'Anonymous User'}</span> commented
                        </div>
                        <div>
                            <time dateTime={comment.created_at} className="flex-none py-0.5 text-xs/5 text-gray-500">
                                {timeSince(comment.created_at)}
                            </time>
                        </div>
                    </div>
                </div>
                <div className="text-sm/6 text-gray-500">{comment.content}</div>
            </div>
        </>
    );
}
