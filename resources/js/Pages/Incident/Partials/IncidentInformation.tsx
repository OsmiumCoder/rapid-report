import {Incident} from "@/types/Incident";
import dateTimeFormat from "@/Filters/dateTimeFormat";
import {util} from "prettier";
import isNextLineEmpty = util.isNextLineEmpty;

{/*
Affected Party Information -> Div #1
-> display even if empty

Incident Information -> Div #2

Victim Information -> Div #3

Witnesses and Supervisor -> Div #4
-> make empty section with that title

General Description -> Div #5

separate each div with a line
*/}
export default function IncidentInformation({ incident }: {incident: Incident}) {
    return (

        <div
            className="bg-white -mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
            <h2 className="text-base font-semibold text-gray-900">Incident</h2>

            {/* Affected Party Information */}
            <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                <dt className="font-semibold text-gray-900">
                    Affected Party Information
                </dt>
                <dd className="mt-2 text-gray-500">
                    <span className="text-gray-900">
                        <span className="font-semibold">Name: </span>
                        {incident.first_name} {incident.last_name}
                        <br/>
                        <span className="font-semibold">UPEI ID: </span>
                        {incident.upei_id || 'Not Applicable'}
                        <br/>
                        <span className="font-semibold">Email: </span>
                        {incident.email}
                        <br/>
                        <span className="font-semibold">Phone: </span>
                        {incident.phone}
                        <br/>
                    </span>
                </dd>
            </div>

            {/* Incident Information */}
            <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                <dt className="font-semibold text-gray-900">
                    Incident Information
                </dt>
                <dd className="mt-2 text-gray-500">
                    <span className="text-gray-900">
                        <span className="font-semibold">Work Related: </span>
                        {incident.work_related}
                        <br/>
                        <span className="font-semibold">Happened At: </span>
                        {incident.happened_at}
                        <br/>
                        <span className="font-semibold">Location: </span>
                        {incident.location}
                        <br/>
                        <span className="font-semibold">Room Number: </span>
                        {incident.room_number || 'Not provided'}
                        <br/>
                        <span className="font-semibold">Reported To: </span>
                        {incident.reported_to || 'Not provided'}
                        <br/>
                    </span>
                </dd>
            </div>

            {/* Victim Information */}
            <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                <dt className="font-semibold text-gray-900">
                    Victim Information
                </dt>
                <dd className="mt-2 text-gray-500">
                    <span className="text-gray-900">
                        <span className="font-semibold">Injury Description: </span>
                        {incident.injury_description || 'No injuries were sustained'}
                        <br/>
                        <span className="font-semibold">First-Aid: </span>
                        {incident.first_aid_description || 'No first-aid was administered'}
                        <br/>
                    </span>
                </dd>
            </div>

            {/* Witnesses and Supervisor */}
            <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                <dt className="font-semibold text-gray-900">
                    Witnesses and Supervisor
                </dt>
                {/* This will remain empty for now */}
            </div>

            {/* General Description */}
            <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                <dt className="font-semibold text-gray-900">
                    General Description
                </dt>
                <dd className="mt-2 text-gray-500">
                    <span className="text-gray-900">
                        <span className="font-semibold">Type: </span>
                        {incident.descriptor}
                        <br/>
                        <span className="font-semibold">Description: </span>
                        {incident.description}
                        <br/>
                        <span className="font-semibold">Status: </span>
                        {incident.status}
                        <br/>
                        <span className="font-semibold">Created at: </span>
                        {incident.created_at}
                        <br/>
                        <span className="font-semibold">Updated at: </span>
                        {incident.updated_at}
                        <br/>
                        <span className="font-semibold">Closed at: </span>
                        {incident.closed_at || "N/A"}
                        <br/>
                        <span className="font-semibold">Deleted at: </span>
                        {incident.deleted_at || 'N/A'}
                        <br/>
                    </span>
                </dd>
            </div>
        </div>
    );
}
