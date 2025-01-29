import { Dispatch, PropsWithChildren, SetStateAction } from 'react';
import ProgressBarCircle from '@/Components/ProgressBarCircle';
import IncidentData from '@/types/IncidentData';

export interface StageProps extends PropsWithChildren {
    formData: IncidentData;
    setFormData: (key: keyof IncidentData, value: any) => void;
    validStep: boolean;
    setValidStep: Dispatch<SetStateAction<boolean>>;
    failedStep: boolean;
    setShowButtons: Dispatch<SetStateAction<boolean>>;
}

interface StageWrapperProps extends PropsWithChildren {
    completedSteps: number;
    remainingSteps: number;
}

export default function StageWrapper({
    completedSteps,
    remainingSteps,
    children,
}: StageWrapperProps) {
    return (
        <>
            <div className="flex justify-center">
                <ProgressBarCircle
                    completedSteps={completedSteps}
                    remainingSteps={remainingSteps}
                ></ProgressBarCircle>
            </div>
            <div className="relative flex gap-3">{children}</div>
        </>
    );
}
