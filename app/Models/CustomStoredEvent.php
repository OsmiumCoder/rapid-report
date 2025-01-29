<?php

namespace App\Models;

use App\StorableEvents\Incident\IncidentCreated;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

class CustomStoredEvent extends EloquentStoredEvent
{
    public static function boot()
    {
        parent::boot();

        static::creating(function (CustomStoredEvent $storedEvent) {

            if ($storedEvent->getOriginalEvent() instanceof IncidentCreated && $storedEvent->getOriginalEvent()->anonymous) {
                $storedEvent->meta_data['user_id'] = null;
            } else {
                $storedEvent->meta_data['user_id'] = auth()->user()->id ?? null;
            }
        });
    }
}
