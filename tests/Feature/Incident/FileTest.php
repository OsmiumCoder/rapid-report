<?php

namespace Incident;

use App\Enum\CommentType;
use App\Models\File;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\FilesUploadedNotification;
use App\States\IncidentStatus\Assigned;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function test_forbidden_supervisor_cant_download_not_owned_file()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $file = File::first();

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $response = $this->get(route('incidents.download-files', ['incident' => $incident->id, 'file' => $file->id]));

        $response->assertForbidden();
    }

    public function test_supervisor_can_download_own_file()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $file = File::first();

        $response = $this->get(route('incidents.download-files', ['incident' => $incident->id, 'file' => $file->id]));

        $response->assertDownload($file->original_name);
    }

    public function test_user_forbidden_to_download_file()
    {
        $incident = Incident::factory()->create();
        $file = File::factory()
            ->for($incident, 'fileable')
            ->for(User::factory(), 'user')
            ->create();

        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $response = $this->get(route('incidents.download-files', ['incident' => $incident->id, 'file' => $file->id]));

        $response->assertForbidden();
    }

    public function test_download_file_downloads_file()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $file = File::first();
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $response = $this->get(route('incidents.download-files', ['incident' => $incident->id, 'file' => $file->id]));

        $response->assertDownload($file->original_name);
    }

    public function test_admin_notified_files_uploaded()
    {
        Notification::fake();
        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->image('file.jpg')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (FilesUploadedNotification $notification, array $channels) use ($incident, $supervisor) {
                return $notification->incidentSlug === $incident->slug && $notification->user->id === $supervisor->id;
            }
        );
    }

    public function test_files_uploaded_comment_added_to_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->image('file.jpg')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $incident->refresh();

        $comment = $incident->comments->first();

        $this->assertEquals($supervisor->id, $comment->user_id);
        $this->assertEquals(CommentType::ACTION, $comment->type);
        $this->assertStringContainsStringIgnoringCase('files', $comment->content);
        $this->assertStringContainsStringIgnoringCase('uploaded', $comment->content);
    }

    public function test_file_model_stored_to_database()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $this->assertDatabaseCount('files', 0);

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $this->assertDatabaseCount('files', 1);

        $file = File::first();

        $this->assertStringStartsWith($incident->id, $file->name);
        $this->assertEquals('file.pdf', $file->original_name);
        $this->assertEquals($incident->id, $file->path);
        $this->assertEquals('102400', $file->size);
        $this->assertEquals('application/pdf', $file->mime_type);
        $this->assertEquals('pdf', $file->extension);

        $incident->refresh();

        $this->assertEquals($incident->id, $file->fileable->id);
    }

    public function test_stores_files_in_storage()
    {
        Storage::fake('public');
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = [
            UploadedFile::fake()->image('file.jpg')->size(100),
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        Storage::assertCount('/'.$incident->id, 2);
    }

    public function test_throws_validation_on_bad_data()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create([
            'supervisor_id' => $supervisor->id,
            'status' => Assigned::class
        ]);

        $files = ['file'];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $this->assertInstanceOf(ValidationException::class, $response->exception);
    }

    public function test_user_forbidden_to_upload_files()
    {
        $user = User::factory()->create()->syncRoles('user');
        $this->actingAs($user);

        $incident = Incident::factory()->create();

        $files = [
            UploadedFile::fake()->image('file.jpg')->size(100),
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $response->assertForbidden();
    }

    public function test_admin_forbidden_to_upload_files()
    {
        $admin = User::factory()->create()->syncRoles('admin');
        $this->actingAs($admin);

        $incident = Incident::factory()->create();

        $files = [
            UploadedFile::fake()->image('file.jpg')->size(100),
            UploadedFile::fake()->create('file.pdf')->size(100),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $response->assertForbidden();
    }
}
