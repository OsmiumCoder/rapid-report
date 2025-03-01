<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $appends = ['url'];

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::temporaryUrl('', now()->addMinute()),
        );
    }

    public function fileable()
    {
        return $this->morphTo();
    }
}
