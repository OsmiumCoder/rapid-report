import {Comment} from "@/types/Comment";
import {ChatBubbleBottomCenterTextIcon} from "@heroicons/react/20/solid";
import dateTimeFormat from "@/Filters/dateTimeFormat";

export default function NoteComment(props: { comment: Comment }) {
    return (
        <>
            <ChatBubbleBottomCenterTextIcon className="text-blue-600 relative flex size-6 flex-none items-center justify-center bg-white" />

            <div className="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                <div className="flex justify-between gap-x-4">
                    <div className="py-0.5 text-xs/5 text-gray-500">
                        <span className="font-medium text-gray-900">
                            {props.comment.user?.name ?? 'Anonymous User'}
                        </span>{' '}
                        commented
                    </div>
                    <time
                        dateTime={props.comment.created_at}
                        className="flex-none py-0.5 text-xs/5 text-gray-500"
                    >
                        {dateTimeFormat(props.comment.created_at)}
                    </time>
                </div>
                <p className="text-sm/6 text-gray-500">
                    {props.comment.content}
                </p>
            </div>
        </>
    );
}
