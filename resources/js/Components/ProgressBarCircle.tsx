import { CheckIcon } from '@heroicons/react/20/solid';
import classNames from '@/Filters/classNames';

export interface Step {
    name: string;
    status: string;
}

interface ProgressBarCircleProps {
    completedSteps: number;
    remainingSteps: number;
}

export default function ProgressBarCircle({
    completedSteps,
    remainingSteps,
}: ProgressBarCircleProps) {
    return (
        <nav aria-label="Progress">
            <ol role="list" className="flex items-center">
                {new Array(completedSteps).fill(1).map((_, index) => (
                    <li key={index} className="pr-8 sm:pr-11 relative">
                        <div
                            aria-hidden="true"
                            className="absolute inset-0 flex items-center"
                        >
                            <div className="h-0.5 w-full bg-indigo-600" />
                        </div>
                        <div
                            className="relative flex size-8 items-center justify-center rounded-full bg-indigo-600"
                        >
                            <CheckIcon
                                aria-hidden="true"
                                className="size-5 text-white"
                            />
                        </div>
                        <span className="sr-only">Completed Step</span>
                    </li>
                ))}

                <li
                    className={classNames(
                        remainingSteps !== 0 ? 'pr-8 sm:pr-11' : '',
                        'relative'
                    )}
                >
                    <div
                        aria-hidden="true"
                        className="absolute inset-0 flex items-center"
                    >
                        <div className="h-0.5 w-full bg-gray-200" />
                    </div>
                    <div
                        aria-current="step"
                        className="relative flex size-8 items-center justify-center rounded-full border-2 border-indigo-600 bg-white"
                    >
                        <span
                            aria-hidden="true"
                            className="size-2.5 rounded-full bg-indigo-600"
                        />
                        <span className="sr-only">Current</span>
                    </div>
                </li>

                {new Array(remainingSteps).fill(1).map((_, index) => (
                    <li
                        key={index}
                        className={classNames(
                            index !== remainingSteps - 1 ? 'pr-8 sm:pr-11' : '',
                            'relative'
                        )}
                    >
                        <div
                            aria-hidden="true"
                            className="absolute inset-0 flex items-center"
                        >
                            <div className="h-0.5 w-full bg-gray-200" />
                        </div>
                        <div
                            className="group relative flex size-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white"
                        >
                            <span className="sr-only">Incomplete Step</span>
                        </div>
                    </li>
                ))}
            </ol>
        </nav>
    );
}
