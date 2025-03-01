<?php

namespace Models;

use App\Models\File;
use App\Models\Incident;
use Tests\TestCase;

class FileTest extends TestCase
{
    public function test_creates_a_file_model_and_attaches_to_incident()
    {
        $file = File::factory()
            ->for(Incident::factory(), 'fileable')
            ->create();

        $this->assertInstanceOf(Incident::class, $file->fileable);

    }
}
