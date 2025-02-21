<?php

namespace Report;

use App\Data\ReportExportData;
use App\Models\Incident;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Inertia\Testing\AssertableInertia;
use Tests\TestCase;

class DownloadCSVTest extends TestCase
{
    public function test_successful_download_csv()
    {
        Storage::fake();
        $admin = User::factory()->create()->syncRoles('admin');
        $exportData = ReportExportData::validateAndCreate([
            'start' => now()->toString(),
            'end' => now()->toString(),
            'happened_at' => false,
            'work_related' => false,
            'personal_individual_information' => false,
            'workers_comp_submitted' => true,
            'location' => false,
            'room_number' => false,
            'incident_type' => false,
            'descriptor' => false,
            'description' => true,
            'injury_description' => false,
            'first_aid_description' => false,
            'closed_at' => false,
            'created_at' => false,
            'updated_at' => false,
        ]);
        $response = $this->actingAs($admin)->post(route('report.downloadFileCSV'), $exportData->toArray());
        $response->assertDownload();

    }
    public function test_throws_validation_error_for_bad_data()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $exportData = [
            'start' => true,
            'end' => false,
            'happened_at' => 'false',
            'work_related' => 1,
            'personal_individual_information' => 'false',
            'workers_comp_submitted' => 'false',
            'location' => 2.3,
            'room_number' => 'false',
            'incident_type' => 0,
            'descriptor' => 45,
            'description' => 'false',
            'injury_description' => 'false',
            'first_aid_description' => 'false',
            'closed_at' => 'false',
            'created_at' => 'false',
            'updated_at' => 'false',
        ];
        $response = $this->actingAs($admin)->post(route('report.downloadFileCSV'), $exportData);
        $this->assertInstanceOf(ValidationException::class, $response->exception);
    }
    public function test_user_is_forbidden()
    {
        $user = User::factory()->create()->syncRoles('user');
        $exportData = ReportExportData::validateAndCreate([
            'start' => now()->toString(),
            'end' => now()->toString(),
            'happened_at' => false,
            'work_related' => false,
            'personal_individual_information' => false,
            'workers_comp_submitted' => true,
            'location' => false,
            'room_number' => false,
            'incident_type' => false,
            'descriptor' => false,
            'description' => true,
            'injury_description' => false,
            'first_aid_description' => false,
            'closed_at' => false,
            'created_at' => false,
            'updated_at' => false,
        ]);
        $response = $this->actingAs($user)->post(route('report.downloadFileCSV'), $exportData->toArray());
        $response->assertForbidden();
    }

    public function test_supervisor_is_forbidden()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $exportData = ReportExportData::validateAndCreate([
            'start' => now()->toString(),
            'end' => now()->toString(),
            'happened_at' => false,
            'work_related' => false,
            'personal_individual_information' => false,
            'workers_comp_submitted' => true,
            'location' => false,
            'room_number' => false,
            'incident_type' => false,
            'descriptor' => false,
            'description' => true,
            'injury_description' => false,
            'first_aid_description' => false,
            'closed_at' => false,
            'created_at' => false,
            'updated_at' => false,
        ]);
        $response = $this->actingAs($supervisor)->post(route('report.downloadFileCSV'), $exportData->toArray());
        $response->assertForbidden();
    }

}
