<?php

namespace App\StorableEvents\Incident;

use App\Models\File;
use App\StorableEvents\StoredEvent;

class FileCreated extends StoredEvent
{
    public function __construct(
        public string $name,
        public string $original_name,
        public string $path,
        public int $size,
        public string $mime_type,
        public string $extension,
        public string $fileable_id,
        public string $fileable_type,
    ) {
    }

    public function handle()
    {
        $file = new File;

        $file->name = $this->name;
        $file->original_name = $this->original_name;
        $file->path = $this->path;
        $file->size = $this->size;
        $file->mime_type = $this->mime_type;
        $file->extension = $this->extension;
        $file->fileable_id = $this->fileable_id;
        $file->fileable_type = $this->fileable_type;

        $file->save();
    }
}
