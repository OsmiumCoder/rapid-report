import GuestLayout from '@/Layouts/GuestLayout';
import { PageProps } from '@/types';
import React from 'react';
import IncidentData from '@/types/IncidentData';

export default function Created({ incident_id }: PageProps<{ incident_id: string }>) {


    return (
        <GuestLayout>
            {incident_id}
        </GuestLayout>
    );
}
