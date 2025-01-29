import {Comment} from "@/types/Comment";
import {InformationCircleIcon} from "@heroicons/react/20/solid";
import dateTimeFormat from "@/Filters/dateTimeFormat";

export default function ActionComment(props: { comment: Comment }) {
    return (
        <>
            <div className="relative flex size-6 flex-none items-center justify-center bg-white">
                <InformationCircleIcon
                    aria-hidden="true"
                    className="size-6 text-amber-500"
                />
            </div>
            <p className="flex-auto py-0.5 text-xs/5 text-gray-500">
                <span className="font-medium text-gray-900">
                    {props.comment.user?.name ?? 'Anonymous User'}
                </span>{' '}
                {props.comment.content}
            </p>
            <time
                dateTime={props.comment.created_at}
                className="flex-none py-0.5 text-xs/5 text-gray-500"
            >
                {dateTimeFormat(props.comment.created_at)}
            </time>
        </>
    );
}
