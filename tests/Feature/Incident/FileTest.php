<?php

namespace Incident;

use App\Enum\CommentType;
use App\Models\File;
use App\Models\Incident;
use App\Models\User;
use App\Notifications\Incident\FilesUploadedNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function test_admin_notified_files_uploaded()
    {
        Notification::fake();
        $admins = User::factory(3)->create()->each(function (User $user) {
            $user->syncRoles('admin');
        });

        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();

        $files = [
            UploadedFile::fake()->image('file.jpg'),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);
        Notification::assertCount(3);

        Notification::assertSentTo(
            $admins,
            function (FilesUploadedNotification $notification, array $channels) use ($incident, $supervisor) {
                return $notification->incidentId === $incident->id && $notification->user->id === $supervisor->id;
            }
        );
    }

    public function test_files_uploaded_comment_added_to_incident()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();

        $files = [
            UploadedFile::fake()->image('file.jpg'),
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

        $incident = Incident::factory()->create();

        $files = [
            UploadedFile::fake()->image('file.jpg'),
        ];

        $this->assertDatabaseCount('files', 0);

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $this->assertDatabaseCount('files', 1);

        $file = File::first();

        $this->assertEquals('stored-path-name', $file->name);
        $this->assertEquals('file.pdf', $file->original_name);
        $this->assertEquals($incident->id, $file->path);
        $this->assertEquals('100', $file->size);
        $this->assertEquals('application/pdf', $file->mime_type);
        $this->assertEquals('pdf', $file->extension);

        $incident->refresh();

        $this->assertEquals($incident->id, $file->fileable->id);
    }

    public function test_stores_files_in_storage()
    {
        Storage::fake('files');
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();

        $files = [
            UploadedFile::fake()->image('file.jpg'),
            UploadedFile::fake()->create('file.pdf'),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        Storage::disk('files')->assertCount($incident->id, 2);

        Storage::disk('files')->assertExists(['file.jpg', 'file.pdf']);
    }

    public function test_throws_validation_on_bad_data()
    {
        $supervisor = User::factory()->create()->syncRoles('supervisor');
        $this->actingAs($supervisor);

        $incident = Incident::factory()->create();

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
            UploadedFile::fake()->image('file.jpg'),
            UploadedFile::fake()->create('file.pdf'),
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
            UploadedFile::fake()->image('file.jpg'),
            UploadedFile::fake()->create('file.pdf'),
        ];

        $response = $this->post(route('incidents.upload-files', $incident), ['files' => $files]);

        $response->assertForbidden();
    }
}
