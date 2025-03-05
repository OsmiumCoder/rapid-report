import dateTimeFormat from '@/Formatters/dateTimeFormat';
import { Incident } from '@/types/incident/Incident';

export default function ReportingInformation({ incident }: { incident: Incident }) {
    return (
        <dl className="mt-6 border-t border-gray-900/5 pt-6 text-gray-900 sm:pr-4">
            <dt className="text-xl font-semibold">Reporting Information</dt>
            <dl className="mt-2 ml-6">
                <div>
                    <span className="font-semibold">Submitted at: </span>
                    {dateTimeFormat(incident.created_at)}
                </div>
                <div>
                    <span className="font-semibold">Anonymous: </span>
                    {incident.anonymous ? 'Yes' : 'No'}
                </div>
                {!incident.anonymous && incident.on_behalf && (
                    <div>
                        <span className="font-semibold">Reporters Email: </span>
                        {incident.reporters_email}
                    </div>
                )}
                <div>
                    <span className="font-semibold">On Behalf: </span>
                    {incident.on_behalf ? 'Yes' : 'No'}
                </div>
                {incident.on_behalf && (
                    <div>
                        <span className="font-semibold">On Behalf Anonymous: </span>
                        {incident.on_behalf_anonymous ? 'Yes' : 'No'}
                    </div>
                )}
            </dl>
        </dl>
    );
}
