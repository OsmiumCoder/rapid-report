import classNames from '@/Filters/classNames';
import { Comment } from '@/types/Comment';
import AddCommentForm from '@/Pages/Incident/Partials/ShowComponents/ActivityLogComponents/AddCommentForm';
import { CommentType } from '@/Enums/CommentType';
import NoteComment from '@/Pages/Incident/Partials/ShowComponents/ActivityLogComponents/CommentComponents/NoteComment';
import ActionComment from '@/Pages/Incident/Partials/ShowComponents/ActivityLogComponents/CommentComponents/ActionComment';
import { FormEvent, useEffect, useRef } from 'react';

interface ActivityLogProps {
    comments: Comment[];
    addComment: (e: FormEvent<HTMLFormElement>) => void;
    setData: ((data: { content: string }) => void) &
        ((
            data: (previousData: { content: string }) => {
                content: string;
            }
        ) => void) &
        (<K extends keyof { content: string }>(key: K, value: { content: string }[K]) => void);
    processing: boolean;
    data: { content: string };
}

export default function ActivityLog({
    comments,
    addComment,
    setData,
    processing,
    data,
}: ActivityLogProps) {
    const commentFormRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (commentFormRef.current) {
            commentFormRef.current.scrollTop = commentFormRef.current.scrollHeight;
        }
    }, []);

    return (
        <>
            <div
                ref={commentFormRef}
                className="lg:col-start-3 p-5 rounded-lg bg-white shadow-sm ring-1 ring-gray-900/5 max-h-[55rem] overflow-y-scroll"
            >
                <h2 className="text-sm/6 font-semibold text-gray-900">Activity</h2>
                <ul role="list" className="mt-6 space-y-6">
                    {comments.map((comment, index) => (
                        <li key={index} className="relative flex gap-x-4">
                            <div
                                className={classNames(
                                    index === comments.length - 1 ? 'h-6' : '-bottom-6',
                                    'absolute left-0 top-0 flex w-6 justify-center'
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

                <AddCommentForm
                    data={data}
                    setData={setData}
                    processing={processing}
                    submit={addComment}
                />
            </div>
        </>
    );
}
