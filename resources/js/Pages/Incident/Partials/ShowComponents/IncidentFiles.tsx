import FileIcon from '@/Components/FileIcon';
import dateFormat from '@/Formatters/dateFormat';
import { Incident } from '@/types/incident/Incident';

export default function IncidentFiles({ incident }: { incident: Incident }) {
    return (
        <>
            {incident.files.length > 0 && (
                <div className="mt-6 flex w-full flex-col gap-y-6 px-6 pb-6">
                    <div className="font-semibold">
                        Files
                        {incident.files.map((file) => (
                            <div key={file.url} className="font-normal">
                                <a
                                    href={route('incidents.download-files', { incident: incident.id, file: file.id })}
                                    target="_blank"
                                    className="cursor-pointer text-sm text-blue-500 hover:text-blue-400"
                                >
                                    <div className="mt-3 flex items-center">
                                        <FileIcon extension={file.extension} className="mr-6 size-6" />
                                        {file.user.name} - {dateFormat(file.created_at)} - {file.original_name}
                                    </div>
                                </a>
                            </div>
                        ))}
                    </div>
                </div>
            )}
        </>
    );
}
