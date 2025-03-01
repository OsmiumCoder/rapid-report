import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import fileSizeFormat from '@/Formatters/fileSizeFormat';
import { Incident } from '@/types/incident/Incident';
import { useForm } from '@inertiajs/react';
import { useRef } from 'react';

interface FileUploadModalProps {
    incident: Incident;
    isOpen: boolean;
    onClose: () => void;
}

export default function FileUploadModal({ incident, isOpen, onClose }: FileUploadModalProps) {
    const { data, setData, post, errors, processing, cancel, reset } = useForm({
        files: [] as File[],
    });

    const fileInputRef = useRef<HTMLInputElement>(null);

    const handleSubmit = () => {
        post(route('incidents.upload-files', { incident: incident.id }), {
            onSuccess: () => {
                onClose();
                reset();
            },
            onError: (err) => console.error(err),
        });
    };

    const handleClose = () => {
        if (processing) {
            cancel();
        }

        onClose();
    };

    return (
        <Modal show={isOpen} onClose={onClose}>
            <input
                onChange={(e) => setData('files', e.target.files ? Array.from(e.target.files) : [])}
                ref={fileInputRef}
                className="absolute z-[-1] h-[0.1px] w-[0.1px] overflow-hidden opacity-0"
                type="file"
                accept=".txt, .rtf, .pdf, .doc, .docx, .jpg, .jpeg, .png"
                multiple
            />
            <div className="flex w-full flex-col items-center space-y-4 px-8 py-6">
                <div className="text-center text-xl font-semibold text-gray-900">Upload Your Files</div>

                <InputLabel>Supported file types: pdf, doc, docx, txt, rtf, png, jpg, jpeg</InputLabel>
                <PrimaryButton onClick={() => fileInputRef.current?.click()} className="w-full">
                    Choose Files
                </PrimaryButton>
                <InputError message={errors.files} />
                {data.files.length > 0 && (
                    <div className="mt-4 max-h-64 w-full space-y-4 overflow-y-scroll px-3">
                        {data.files.map((file, i) => (
                            <div key={i} className="flex items-center justify-between border-b border-gray-200 py-2">
                                <div className="flex-1 text-sm text-gray-700">{file.name}</div>

                                <div className="flex items-center space-x-4">
                                    <div className="text-sm text-gray-500">{fileSizeFormat(file.size)}</div>
                                    <DangerButton onClick={() => setData('files', [...data.files.slice(0, i), ...data.files.slice(i + 1)])}>
                                        Delete
                                    </DangerButton>
                                </div>
                            </div>
                        ))}
                    </div>
                )}

                <div className="mt-6 flex justify-between space-x-14">
                    <DangerButton onClick={handleClose} className="w-1/2">
                        Cancel
                    </DangerButton>
                    <PrimaryButton disabled={processing} onClick={handleSubmit} className="w-1/2">
                        Submit
                    </PrimaryButton>
                </div>
            </div>
        </Modal>
    );
}
