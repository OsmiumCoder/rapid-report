<?php

namespace App\Models;

use App\Enum\NotificationMessageType;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class NotificationMessage extends Model
{
    use HasUuids;

    protected $fillable = [
        'name',
        'message',
    ];

    public function casts()
    {
        return [
            'name' => NotificationMessageType::class,
        ];
    }
}
