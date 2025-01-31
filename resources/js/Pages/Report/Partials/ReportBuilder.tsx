import React, {Dispatch, PropsWithChildren, SetStateAction, useEffect, useState} from 'react';
import Witness from "@/types/incident/Witness";
import ReportData from "@/types/report/ReportData";
import { useForm } from '@inertiajs/react';
import {PageProps} from "@/types";
import {Incident} from "@/types/incident/Incident";
export interface ReportBuildingBlockProps {
    key: keyof ReportData;
    formData: ReportData;
    setFormData: (key: keyof ReportData, value: any) => void;
}

export default function ReportBuilder({
    form,
    auth,
}: PageProps<{form: ReportData}>,{
    incidents,
}: {incidents: Incident[]}){
    const {
        data: formData,
        setData,
        post,
        processing,
    } = useForm<Partial<ReportData>>(form);


}
