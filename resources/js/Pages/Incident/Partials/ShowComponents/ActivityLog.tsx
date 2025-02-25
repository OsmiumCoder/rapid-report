import { CommentType } from '@/Enums/CommentType';
import classNames from '@/Filters/classNames';
import AddCommentForm from '@/Pages/Incident/Partials/ShowComponents/ActivityLogComponents/AddCommentForm';
import ActionComment from '@/Pages/Incident/Partials/ShowComponents/ActivityLogComponents/CommentComponents/ActionComment';
import NoteComment from '@/Pages/Incident/Partials/ShowComponents/ActivityLogComponents/CommentComponents/NoteComment';
import { Comment } from '@/types/Comment';
import { FormEvent, useEffect, useRef } from 'react';

interface ActivityLogProps {
    comments: Comment[];
    addComment: (e: FormEvent<HTMLFormElement>) => void;
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

export default function ActivityLog({ comments, addComment, setData, processing, data }: ActivityLogProps) {
    const commentFormRef = useRef<HTMLUListElement>(null);

    useEffect(() => {
        if (commentFormRef.current) {
            commentFormRef.current.scrollTop = commentFormRef.current.scrollHeight;
        }
    }, [comments]);

    return (
        <>
            <div className="rounded-lg bg-white p-5 shadow-sm ring-1 ring-gray-900/5 lg:col-start-3">
                <h2 className="text-sm/6 font-semibold text-gray-900">Activity</h2>
                <ul ref={commentFormRef} role="list" className="mt-6 max-h-[55rem] space-y-6 overflow-y-scroll">
                    {comments.map((comment, index) => (
                        <li key={index} className="relative flex gap-x-4">
                            <div
                                className={classNames(
                                    index === comments.length - 1 ? 'h-6' : '-bottom-6',
                                    'absolute top-0 left-0 flex w-6 justify-center',
                                )}
                            >
                                <div className="w-px bg-gray-200" />
                            </div>

                            {comment.type === CommentType.NOTE ? (
                                <NoteComment comment={comment} />
                            ) : comment.type === CommentType.ACTION ? (
                                <ActionComment comment={comment} />
                            ) : (
                                <></>
                            )}
                        </li>
                    ))}
                </ul>

                <AddCommentForm data={data} setData={setData} processing={processing} submit={addComment} />
            </div>
        </>
    );
}
