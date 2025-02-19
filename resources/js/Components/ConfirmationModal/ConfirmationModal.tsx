import { RefObject } from 'react';
import PrimaryButton from '@/Components/PrimaryButton';
import DangerButton from '@/Components/DangerButton';
import { Dialog, DialogBackdrop, DialogPanel, DialogTitle } from '@headlessui/react';
import { ExclamationTriangleIcon } from '@heroicons/react/16/solid';

export interface ConfirmationModalProps {
    title: string;
    text: string;
    action: CallableFunction;
    show: boolean;
    setShow: (show: boolean) => void;
}

export default function ConfirmationModal({
    modalProps,
    modalRef,
}: {
    modalProps: ConfirmationModalProps;
    modalRef: RefObject<HTMLDivElement>;
}) {
    const { title, text, show, setShow, action } = modalProps;

    const handleYes = () => {
        action();
        setShow(false);
    };

    const handleNo = () => setShow(false);

    return (
        <Dialog open={show} onClose={() => {}} className="relative z-10">
            <DialogBackdrop
                transition
                className="fixed inset-0 bg-gray-500/75 transition-opacity data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in"
            />

            <div ref={modalRef} className="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div className="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <DialogPanel
                        transition
                        className="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all data-[closed]:translate-y-4 data-[closed]:opacity-0 data-[enter]:duration-300 data-[leave]:duration-200 data-[enter]:ease-out data-[leave]:ease-in sm:my-8 sm:w-full sm:max-w-lg sm:p-6 data-[closed]:sm:translate-y-0 data-[closed]:sm:scale-95"
                    >
                        <div>
                            <div className="mx-auto flex size-12 items-center justify-center rounded-full bg-gray-100">
                                <ExclamationTriangleIcon
                                    aria-hidden="true"
                                    className="size-6 text-yellow-500 "
                                />
                            </div>
                            <div className="mt-3 text-center sm:mt-5">
                                <DialogTitle
                                    as="h3"
                                    className="text-base font-semibold text-gray-900"
                                >
                                    {title}
                                </DialogTitle>
                                <div className="mt-2">
                                    <p className="text-sm text-gray-500">{text}</p>
                                </div>
                            </div>
                        </div>
                        <div className="mt-5 sm:mt-6 sm:grid sm:grid-flow-row-dense sm:grid-cols-2 sm:gap-3">
                            <DangerButton data-autofocus onClick={handleNo}>
                                No
                            </DangerButton>
                            <PrimaryButton onClick={handleYes}>Yes</PrimaryButton>
                        </div>
                    </DialogPanel>
                </div>
            </div>
        </Dialog>
    );
}
