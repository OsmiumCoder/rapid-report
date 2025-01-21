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
                        <a
                            href="#"
                            className="relative flex size-8 items-center justify-center rounded-full bg-indigo-600 hover:bg-indigo-900"
                        >
                            <CheckIcon
                                aria-hidden="true"
                                className="size-5 text-white"
                            />
                        </a>
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
                    <a
                        href="#"
                        aria-current="step"
                        className="relative flex size-8 items-center justify-center rounded-full border-2 border-indigo-600 bg-white"
                    >
                        <span
                            aria-hidden="true"
                            className="size-2.5 rounded-full bg-indigo-600"
                        />
                        <span className="sr-only">Current</span>
                    </a>
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
                        <a
                            href="#"
                            className="group relative flex size-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white hover:border-gray-400"
                        >
                            <span
                                aria-hidden="true"
                                className="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"
                            />
                            <span className="sr-only">Incomplete Step</span>
                        </a>
                    </li>
                ))}

                {/*{steps.map((step, stepIdx) => (*/}
                {/*    <li key={step.name}>*/}
                {/*        {step.status === 'complete' ? (*/}
                {/*            <>*/}
                {/*                <div*/}
                {/*                    aria-hidden="true"*/}
                {/*                    className="absolute inset-0 flex items-center"*/}
                {/*                >*/}
                {/*                    <div className="h-0.5 w-full bg-indigo-600" />*/}
                {/*                </div>*/}
                {/*                <a*/}
                {/*                    href="#"*/}
                {/*                    className="relative flex size-8 items-center justify-center rounded-full bg-indigo-600 hover:bg-indigo-900"*/}
                {/*                >*/}
                {/*                    <CheckIcon*/}
                {/*                        aria-hidden="true"*/}
                {/*                        className="size-5 text-white"*/}
                {/*                    />*/}
                {/*                </a>*/}
                {/*            </>*/}
                {/*        ) : step.status === 'current' ? (*/}
                {/*            <>*/}
                {/*                <div*/}
                {/*                    aria-hidden="true"*/}
                {/*                    className="absolute inset-0 flex items-center"*/}
                {/*                >*/}
                {/*                    <div className="h-0.5 w-full bg-gray-200" />*/}
                {/*                </div>*/}
                {/*                <a*/}
                {/*                    href="#"*/}
                {/*                    aria-current="step"*/}
                {/*                    className="relative flex size-8 items-center justify-center rounded-full border-2 border-indigo-600 bg-white"*/}
                {/*                >*/}
                {/*                    <span*/}
                {/*                        aria-hidden="true"*/}
                {/*                        className="size-2.5 rounded-full bg-indigo-600"*/}
                {/*                    />*/}
                {/*                    <span className="sr-only">{step.name}</span>*/}
                {/*                </a>*/}
                {/*            </>*/}
                {/*        ) : (*/}
                {/*            <>*/}
                {/*                <div*/}
                {/*                    aria-hidden="true"*/}
                {/*                    className="absolute inset-0 flex items-center"*/}
                {/*                >*/}
                {/*                    <div className="h-0.5 w-full bg-gray-200" />*/}
                {/*                </div>*/}
                {/*                <a*/}
                {/*                    href="#"*/}
                {/*                    className="group relative flex size-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white hover:border-gray-400"*/}
                {/*                >*/}
                {/*                    <span*/}
                {/*                        aria-hidden="true"*/}
                {/*                        className="size-2.5 rounded-full bg-transparent group-hover:bg-gray-300"*/}
                {/*                    />*/}
                {/*                    <span className="sr-only">{step.name}</span>*/}
                {/*                </a>*/}
                {/*            </>*/}
                {/*        )}*/}
                {/*    </li>*/}
                {/*))}*/}
            </ol>
        </nav>
    );
}
