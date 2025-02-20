import { createContext, PropsWithChildren, RefObject, useContext, useRef, useState } from 'react';
import ConfirmationModal, {
    ConfirmationModalProps,
} from '@/Components/ConfirmationModal/ConfirmationModal';

interface ConfirmationModalContextType {
    setModalProps: (props: Partial<ConfirmationModalProps>) => void;
    modalRef: RefObject<HTMLDivElement>;
}

const ConfirmationModalContext = createContext<ConfirmationModalContextType | undefined>(undefined);

export const useConfirmationModal = () => {
    const context = useContext(ConfirmationModalContext);
    if (!context)
        throw new Error('useConfirmationModal must be used within a ConfirmationModalProvider');
    return context;
};

export default function ConfirmationModalProvider({ children }: PropsWithChildren) {
    const modalRef = useRef<HTMLDivElement>(null);
    const [modalProps, setProps] = useState<ConfirmationModalProps>({
        title: '',
        text: '',
        action: () => {},
        show: false,
        setShow: (show) => setModalProps((prev) => ({ ...prev, show })),
    });

    const setModalProps = (
        props: Partial<ConfirmationModalProps> | ((prev: ConfirmationModalProps) => void)
    ) => {
        setProps((prev) => ({
            ...prev,
            ...(typeof props === 'function' ? props(prev) : props),
            // Keep show and setShow immutable
            setShow: (show: boolean) => setProps((prev) => ({ ...prev, show })),
        }));
    };

    return (
        <ConfirmationModalContext.Provider value={{ setModalProps, modalRef }}>
            {children}
            <ConfirmationModal modalProps={modalProps} modalRef={modalRef} />
        </ConfirmationModalContext.Provider>
    );
}
