<?php

namespace App\Reactors;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\StorableEvents\StoredEvent;
use Spatie\EventSourcing\EventHandlers\Reactors\Reactor;

class StoredEventReactor extends Reactor implements ShouldQueue
{
    public function onStoredEvent(StoredEvent $event)
    {
        $event->react();
    }
}
