import React, { useEffect } from 'react';
import { StageProps } from '@/Pages/Incident/Stages/StageWrapper';
import { descriptors } from '@/Pages/Incident/Stages/IncidentDropDownValues';
import ToggleSwitch from '@/Components/ToggleSwitch';
import dateFormat from '@/Filters/dateFormat';
import TextInput from '@/Components/TextInput';
import SelectInput from '@/Components/SelectInput';
import DateInput from '@/Components/DateInput';

export default function IncidentInformationStage({
    formData,
    setFormData,
    failedStep,
    setValidStep,
}: StageProps) {
    return (
        <div className="min-w-0 flex-1 text-sm/6">
            <label className="flex justify-center font-bold text-lg text-gray-900">
                Incident Information
            </label>

            <div className="mt-4">
                <label className="block text-sm/6 font-medium text-gray-900">
                    When did this Incident occur?
                </label>
                <div className="mt-2">
                    <DateInput
                        value={formData.happened_at ?? dateFormat(new Date())}
                        onChange={(e) => {
                            setFormData('happened_at', e.target.value);
                        }}
                    />
                </div>
            </div>

            <div className="flex mt-4">
                <div className="min-w-0 flex-1 text-sm/6">
                    <label htmlFor="work_related" className="font-medium text-gray-900">
                        Work Related
                    </label>
                    <p className="text-xs text-gray-500">Was the Incident Work related?</p>
                </div>
                <ToggleSwitch
                    checked={formData.work_related ?? false}
                    onChange={(e) => {
                        setFormData('work_related', e.valueOf());
                    }}
                />
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">Location</label>
                    <p className="text-xs text-gray-500">
                        Enter the building or description of area where the incident occurred.
                    </p>
                </div>

                <div className="mt-2">
                    <TextInput
                        placeholder="e.g Cass Science Hall"
                        aria-describedby="location-description"
                        required
                        value={formData.location ?? ''}
                        onChange={(e) => setFormData('location', e.target.value)}
                    />
                </div>
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">Room Number</label>
                    <p className="text-xs text-gray-500">If Applicable.</p>
                </div>

                <div className="mt-2">
                    <TextInput
                        placeholder="e.g 123A"
                        required
                        value={formData.room_number ?? ''}
                        onChange={(e) => {
                            setFormData('room_number', e.target.value);
                        }}
                    />
                </div>
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Incident Type
                    </label>
                </div>
                <div className="mt-1 grid grid-cols-1">
                    <SelectInput
                        value={
                            descriptors.find(({ value }) => value === formData?.incident_type)
                                ?.name ?? descriptors[0].name
                        }
                        onChange={(e) => {
                            setFormData(
                                'incident_type',
                                descriptors.find(({ name }) => name === e.target.value)?.value
                            );
                        }}
                    >
                        {descriptors.map(({ name }, index) => (
                            <option key={index}>{name}</option>
                        ))}
                    </SelectInput>
                </div>
            </div>

            <div className="mt-4">
                <div>
                    <label className="block text-sm/6 font-medium text-gray-900">
                        Incident Descriptor
                    </label>
                </div>
                <div className="mt-1 grid grid-cols-1">
                    <SelectInput
                        value={formData.descriptor}
                        onChange={(e) => setFormData('descriptor', e.target.value)}
                    >
                        {descriptors.map(
                            ({ options, value }) =>
                                value === formData.incident_type &&
                                options.map((option, index) => (
                                    <option key={index}>{option}</option>
                                ))
                        )}
                    </SelectInput>
                </div>
            </div>

            {formData.descriptor === 'Other' && (
                <div className="mt-4">
                    <div>
                        <label className="block text-sm/6 font-medium text-gray-900">
                            Please briefly Describe:
                        </label>
                    </div>
                    <div className="mt-1">
                        <TextInput
                            required
                            value={formData.other_descriptor ?? ''}
                            onChange={(e) => setFormData('other_descriptor', e.target.value)}
                        />
                    </div>
                </div>
            )}
        </div>
    );
}
