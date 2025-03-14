<?php

namespace Tests\Feature\Report;

use App\Data\IncidentExportData;
use App\Exports\IncidentsExport;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class ExportCSVTest extends TestCase
{
    public function test_xlsx_exported_download_response()
    {

        $admin = User::factory()->create()->syncRoles('admin');

        Incident::factory(5)->create();

        // Our export is from today onward
        // these should thus not be returned
        Incident::factory(5)->create(['created_at' => now()->subDays(10)]);

        $exportData = IncidentExportData::from([
            'start' => now()->toDateString(),
            'end' => now()->addDay()->toDateString(),
            'fields' => ['ID']
        ]);

        $response = $this->actingAs($admin)->post(route('report.export-csv'), $exportData->toArray());

        $response->assertDownload();
    }

    public function test_xlsx_exported()
    {
        Excel::fake();

        $admin = User::factory()->create()->syncRoles('admin');

        Incident::factory(5)->create();

        // Our export is from today onward
        // these should thus not be returned
        Incident::factory(5)->create(['created_at' => now()->subDays(10)]);

        $exportData = IncidentExportData::from([
            'start' => now()->toDateString(),
            'end' => now()->addDay()->toDateString(),
            'fields' => ['ID']
        ]);

        $response = $this->actingAs($admin)->post(route('report.export-csv'), $exportData->toArray());

        Excel::assertDownloaded("{$exportData->start->toDateString()}-to-{$exportData->end->toDateString()}.csv", function (IncidentsExport $export) {
            return $export->query()->count() == 5;
        });
    }

    public function test_throws_validation_error_for_bad_data()
    {
        $admin = User::factory()->create()->syncRoles('admin');

        $exportData = [
            'start' => true,
            'end' => false,
            'fields' => []
        ];

        $response = $this->actingAs($admin)->post(route('report.export-csv'), $exportData);

        $this->assertInstanceOf(ValidationException::class, $response->exception);
    }

    public function test_user_is_forbidden()
    {
        $user = User::factory()->create()->syncRoles('user');

        $exportData = IncidentExportData::from([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['ID']
        ]);

        $response = $this->actingAs($user)->post(route('report.export-csv'), $exportData->toArray());

        $response->assertForbidden();
    }

    public function test_supervisor_is_forbidden()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');

        $exportData = IncidentExportData::from([
            'start' => now()->toDateString(),
            'end' => now()->toDateString(),
            'fields' => ['ID']
        ]);

        $response = $this->actingAs($supervisor)->post(route('report.export-csv'), $exportData->toArray());

        $response->assertForbidden();
    }
}
