<?php

namespace App\Http\Controllers\Report;

use App\Data\ReportExportData;
use App\Enum\IncidentType;
use App\Enum\RoleType;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use DateTime;
use DateTimeImmutable;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use PhpOffice\PhpSpreadsheet\Cell\AdvancedValueBinder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ReportController extends Controller
{
    public function index()
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Index');
    }

    public function stats()
    {
        Gate::authorize('view-report-page');

        return Inertia::render('Report/Stats', [
            'incidents' => Incident::all(),
        ]);
    }

    public function downloadFileXLSX(ReportExportData $exportData)
    {
        Gate::authorize('view-report-page');

        $responseHeaders = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($exportData) {
            $spreadsheet = new Spreadsheet;
            $spreadsheet->setValueBinder(new AdvancedValueBinder);
            $sheet = $spreadsheet->getActiveSheet();

            $headers = [];
            $person_headers = ['anonymous','on_behalf','on_behalf_anonymous','role','last_name','first_name','upei_id','email','phone'];
            $export_array_data = $exportData -> toArray();

            if ($export_array_data['personal_individual_information']) {
                $headers = array_merge($headers, $person_headers);
            }

            $start = DateTimeImmutable::createFromFormat("Y-m-d", $exportData->start);
            $end = DateTimeImmutable::createFromFormat("Y-m-d", $exportData->end);

            unset($export_array_data['start'], $export_array_data['end'],$export_array_data['personal_individual_information']);

            $i = 1;
            foreach ($export_array_data as $key => $value) {
                if ($value) {
                    $headers[] = $key;
                }
            }

            foreach ($headers as $header) {
                $sheet->setCellValue([$i,1], $header);
                $i++;
            }

            Incident::where('created_at', '>', $start)
                ->where('created_at', '<', $end)
                ->chunk(1000, function ($incidents) use ($exportData, $spreadsheet, $sheet, $headers, $start, $end) {
                    $row = 2;
                    foreach ($incidents as $incident) {
                        $col = 1;

                        foreach ($headers as $key) {
                            if ($key == "incident_type") {
                                $sheet->setCellValue(
                                    [$col, $row],
                                    isset($incident->$key) ? IncidentType::toString($incident->$key) : 'N/A'
                                );
                            } elseif ($key == "role") {
                                $sheet->setCellValue(
                                    [$col, $row],
                                    isset($incident->$key) ? RoleType::toString($incident->$key) : 'N/A'
                                );
                            } elseif ($key == "happened_at" || $key == "closed_at" || $key == "created_at" || $key == "updated_at" || $key == "deleted_at") {
                                $time_data = isset($incident->$key) ? DateTime::createFromFormat('Y-m-d H:i:s', $incident->$key) : 'N/A';
                                if ($time_data != "N/A") {
                                    $sheet->setCellValue(
                                        [$col, $row],
                                        Date::PHPToExcel($time_data)
                                    );
                                    $sheet->getStyle([$col, $row])
                                        ->getNumberFormat()
                                        ->setFormatCode(
                                            'yyyy-mm-dd'
                                        );
                                }
                            } else {
                                if (gettype($incident->$key) == "boolean") {
                                    if ($incident->$key) {
                                        $sheet->setCellValue(
                                            [$col, $row],
                                            "True"
                                        );
                                    } else {
                                        $sheet->setCellValue(
                                            [$col, $row],
                                            "False"
                                        );
                                    }
                                } else {
                                    $sheet->setCellValue(
                                        [$col, $row],
                                        isset($incident->$key) ? strval($incident->$key) : 'N/A'
                                    );
                                }
                            }
                            $col++;
                        }
                        $row++;
                    }
                });

            $writer = IOFactory::createWriter($spreadsheet, "Xlsx");
            $writer->save("php://output");
        }, 200, $responseHeaders);
    }

    public function downloadFileCSV(ReportExportData $exportData)
    {
        Gate::authorize('view-report-page');

        $responseHeaders = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($exportData) {
            $output = fopen('php://output', 'w');

            // CSV Header
            fputcsv(
                $output,
                $exportData->fields,
            );

            Incident::whereBetween('created_at', [$exportData->start, $exportData->end])
                ->chunk(100, function (Collection $incidents) use ($exportData, $output) {
                    /* @var Incident $incident */
                    foreach ($incidents as $incident) {
                        $row = [];

                        foreach ($exportData->fields as $field) {
                            if ($field == "incident_type") {
                                $row[] = IncidentType::toString($incident->incident_type);
                            } elseif ($field == "role") {
                                $row[] = $incident->role ? RoleType::toString($incident->role) : 'Anonymous';
                            } elseif ($field == "happened_at") {
                                $row[] = $incident->happened_at->format("Y-m-d");
                            } elseif (str_ends_with($field, "_at")) {
                                $row[] = $incident->$field->format("Y-m-d h:i A");
                            } else {
                                $row[] = $incident->$field;
                            }
                        }

                        fputcsv($output, $row);
                    }
                });

            fclose($output);
        }, 200, $responseHeaders);
    }

}
