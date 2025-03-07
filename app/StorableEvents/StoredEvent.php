<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 * StoredEvent should be inherited for all events
 * and their handle and react methods should be overloaded as needed.
 */
abstract class StoredEvent extends ShouldBeStored
{
    /**
     * Called by the projector.
     */
    public function handle(): void
    {

    }

    /**
     * Called by the reactor.
     *
     * In the event of an event replay code executed
     * within this method will not be replayed.
     */
    public function react(): void
    {

    }
}
