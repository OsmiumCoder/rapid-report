import { Incident } from '@/types/Incident';

export default function WitnessInformation({
    incident,
}: {
    incident: Incident;
}) {
    // TODO Witness Information
    return (
        <div className="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
            <dt className="font-semibold text-gray-900 text-xl">Witnesses</dt>
            {/* This will remain empty for now */}
        </div>
    );
}
