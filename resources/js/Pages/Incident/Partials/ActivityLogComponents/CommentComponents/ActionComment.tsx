import { Comment } from '@/types/Comment';
import { InformationCircleIcon } from '@heroicons/react/20/solid';
import dateTimeFormat from '@/Filters/dateTimeFormat';

export default function ActionComment({ comment }: { comment: Comment }) {
    console.log(comment);

    return (
        <>
            <div className="relative flex size-6 flex-none items-center justify-center bg-white">
                <InformationCircleIcon
                    aria-hidden="true"
                    className="size-6 text-amber-500"
                />
            </div>
            <div className="flex-auto py-0.5 text-xs/5 text-gray-500">
                <div>
                    <span className="font-medium text-gray-900">
                        {comment.user?.name ?? 'Anonymous User'}
                    </span>{' '}
                    {comment.content}
                </div>

                <time
                    dateTime={comment.created_at}
                    className="flex-none py-0.5 text-xs/5 text-gray-500"
                >
                    {dateTimeFormat(comment.created_at)}
                </time>
            </div>
        </>
    );
}
