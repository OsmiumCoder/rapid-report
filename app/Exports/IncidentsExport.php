<?php

namespace App\Exports;

use App\Data\ExportData;
use App\Enum\IncidentType;
use App\Enum\RoleType;
use App\Models\Incident;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class IncidentsExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    public function __construct(
        public ExportData $exportData
    ) {
    }

    public function headings(): array
    {
        return $this->exportData->fields;
    }

    /**
     * @param Incident $row
     */
    public function map($row): array
    {
        $rowItems = [];

        foreach ($this->exportData->fields as $field) {
            if ($field == "incident_type") {
                $rowItems[] = IncidentType::toString($row->incident_type);
            } elseif ($field == "role") {
                $rowItems[] = $row->role ? RoleType::toString($row->role) : 'Anonymous';
            } elseif ($field == "happened_at") {
                $rowItems[] = $row->happened_at->toDateString();
            } elseif (str_ends_with($field, "_at")) {
                if (!$row->$field) {
                    $rowItems[] = $row->$field;
                    continue;
                }
                $rowItems[] = $row->$field->format("Y-m-d h:i A");
            } else {
                $rowItems[] = $row->$field;
            }
        }

        return $rowItems;
    }

    public function query()
    {
        return Incident::query()
            ->whereBetween('created_at', [
                $this->exportData->start->startOfDay(),
                $this->exportData->end->endOfDay()
            ]);
    }
}
