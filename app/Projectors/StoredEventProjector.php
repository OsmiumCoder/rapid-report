<?php

namespace App\Projectors;

use App\StorableEvents\StoredEvent;
use Spatie\EventSourcing\EventHandlers\Projectors\Projector;

class StoredEventProjector extends Projector
{
    public function onStoredEvent(StoredEvent $event)
    {
        $event->handle();
    }
}
