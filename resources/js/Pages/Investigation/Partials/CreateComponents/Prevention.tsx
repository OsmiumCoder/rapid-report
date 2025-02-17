import { InvestigationComponentProps } from '@/Pages/Investigation/Create';
import TextArea from '@/Components/TextArea';
import React from 'react';

export default function Prevention({ formData, setFormData, errors }: InvestigationComponentProps) {
    return (
        <>
            <div className="mb-4">
                <label className="font-semibold text-gray-700">Remedial Actions:</label>
                <p className="text-sm text-gray-600 italic">
                    What has and/or should be done to control the causes listed?
                </p>
                <TextArea
                    value={formData.remedial_actions}
                    onChange={(e) => setFormData('remedial_actions', e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full"
                />
            </div>

            <h3 className="text-lg font-semibold text-gray-700 mt-6">Prevention of Recurrence</h3>

            <div className="mb-4">
                <label className="text-gray-700">Prevention Measures:</label>
                <p className="text-sm text-gray-600 italic">
                    Describe what action is planned or has been taken to prevent a recurrence of the
                    incident, based on the key contributing factors (both immediate and long term).
                </p>
                <TextArea
                    value={formData.prevention}
                    onChange={(e) => setFormData('prevention', e.target.value)}
                    className="p-2 border border-gray-300 rounded-md w-full"
                />
            </div>
        </>
    );
}
