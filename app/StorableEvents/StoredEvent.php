<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

/**
 * StoredEvent should be inherited for all events
 * and there handle and react methods should be overloaded as needed.
 */
class StoredEvent extends ShouldBeStored
{
    /**
     * Called by projector
     *
     * @return void
     */
    public function handle()
    {

    }

    /**
     * Called by the reactor.
     * Will not be replayed on event replays.
     *
     * @return void
     */
    public function react()
    {

    }
}
