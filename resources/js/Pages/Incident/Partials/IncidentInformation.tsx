import {Incident} from "@/types/Incident";
import dateTimeFormat from "@/Filters/dateTimeFormat";

export default function IncidentInformation({ incident }: {incident: Incident}) {
    return (
        <div className="bg-white -mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
            <h2 className="text-base font-semibold text-gray-900">Incident</h2>
            <dl className="mt-6 grid grid-cols-1 text-sm/6 sm:grid-cols-2">
                <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                    <dt className="font-semibold text-gray-900">Summary</dt>
                </div>

                <div className="sm:pr-4">
                    <dt className="inline text-gray-500">Created:</dt>{' '}
                    <dd className="inline text-gray-700">
                        <time>{dateTimeFormat(incident.created_at)}</time>
                    </dd>
                </div>

                <div className="sm:pr-4">
                    <dt className="inline text-gray-500">Last Updated:</dt>{' '}
                    <dd className="inline text-gray-700">
                        <time>{dateTimeFormat(incident.updated_at)}</time>
                    </dd>
                </div>

                <div className="sm:pr-4">
                    <dt className="inline text-gray-500">Status:</dt>{' '}
                    <dd className="inline text-gray-700">
                        <time>{incident.status}</time>
                    </dd>
                </div>
                <br />
                <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                    <dt className="font-semibold text-gray-900">
                        Reporting user
                    </dt>
                    <dd className="mt-2 text-gray-500">
                        <span className="font-medium text-gray-900">
                            {incident.first_name} {incident.last_name}
                        </span>
                        <br />
                        UPEI ID: {incident.upei_id || 'Not Applicable'}
                        <br />
                        Email: {incident.email}
                        <br />
                        Phone: {incident.phone}
                        <br />
                    </dd>
                </div>
                <br />
                <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                    <dt className="font-semibold text-gray-900">Supervisor</dt>
                    <dd className="mt-2 text-gray-500">
                        <span className="font-medium text-gray-900">
                            {incident.supervisor_name || 'None given'}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>
    );
}
