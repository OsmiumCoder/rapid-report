<?php

namespace StoreableEvents\Incident;

use App\Models\File;
use App\Models\Incident;
use App\Models\User;
use App\StorableEvents\Incident\FileCreated;
use Tests\TestCase;

class FileCreatedTest extends TestCase
{
    public function test_stored_file_attached_to_user()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create();

        $event = new FileCreated(
            name: 'stored-path-name',
            original_name: 'file.pdf',
            path: $incident->id,
            size: '100',
            mime_type: 'application/pdf',
            extension: 'pdf',
            fileable_id: $incident->id,
            fileable_type: Incident::class
        );

        $event->setMetaData(['user_id' => $user->id]);

        $this->assertDatabaseCount('files', 0);

        $event->handle();

        $this->assertDatabaseCount('files', 1);

        $file = File::first();

        $this->assertEquals($user->id, $file->user->id);
    }

    public function test_stored_file_attached_to_incident()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create();

        $event = new FileCreated(
            name: 'stored-path-name',
            original_name: 'file.pdf',
            path: $incident->id,
            size: '100',
            mime_type: 'application/pdf',
            extension: 'pdf',
            fileable_id: $incident->id,
            fileable_type: Incident::class
        );

        $event->setMetaData(['user_id' => $user->id]);

        $this->assertDatabaseCount('files', 0);

        $event->handle();

        $this->assertDatabaseCount('files', 1);

        $file = File::first();

        $this->assertEquals($incident->id, $file->fileable->id);
    }

    public function test_file_model_stored_to_database()
    {
        $user = User::factory()->create();

        $incident = Incident::factory()->create();
        $event = new FileCreated(
            name: 'stored-path-name',
            original_name: 'file.pdf',
            path: $incident->id,
            size: '100',
            mime_type: 'application/pdf',
            extension: 'pdf',
            fileable_id: $incident->id,
            fileable_type: Incident::class
        );

        $event->setMetaData(['user_id' => $user->id]);

        $this->assertDatabaseCount('files', 0);

        $event->handle();

        $this->assertDatabaseCount('files', 1);

        $file = File::first();

        $this->assertEquals('stored-path-name', $file->name);
        $this->assertEquals('file.pdf', $file->original_name);
        $this->assertEquals($incident->id, $file->path);
        $this->assertEquals('100', $file->size);
        $this->assertEquals('application/pdf', $file->mime_type);
        $this->assertEquals('pdf', $file->extension);
    }
}
