import ReportData from '@/types/report/ReportData';
import { uppercaseWordFormat } from '@/Filters/uppercaseWordFormat';
import Checkbox from '@/Components/Checkbox';

interface ReportBuildingBlockProps {
    reportDataKey: keyof ReportData;
    formData: ReportData;
    setFormData: Function;
}

export default function ReportBuildingBlock({
    reportDataKey,
    formData,
    setFormData,
}: ReportBuildingBlockProps) {
    return (
        <>
            <div className="flex grid-cols-2 rounded-xl bg-white border-gray-300  border m-3 p-2">
                <div className="mr-3 text-pretty font-medium text-gray-800">
                    {uppercaseWordFormat(reportDataKey)}
                </div>
                <div className="flex h-6 shrink-0 items-center">
                    <div className="group grid size-4 grid-cols-1">
                        <Checkbox
                            checked={formData[reportDataKey] as boolean}
                            type="checkbox"
                            aria-describedby="comments-description"
                            onChange={(e) => setFormData(reportDataKey, e.target.checked)}
                        />
                    </div>
                </div>
            </div>
        </>
    );
}
