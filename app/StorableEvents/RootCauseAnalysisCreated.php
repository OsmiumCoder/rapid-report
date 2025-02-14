<?php

namespace App\StorableEvents;

use Spatie\EventSourcing\StoredEvents\ShouldBeStored;

class RootCauseAnalysisCreated extends ShouldBeStored
{
    public function __construct()
    {
    }
}
