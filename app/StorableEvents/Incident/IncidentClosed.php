<?php

namespace App\StorableEvents\Incident;

use App\Models\Incident;
use App\States\IncidentStatus\Closed;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\StoredEvent;

class IncidentClosed extends StoredEvent
{
    public function handle() {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->status->transitionTo(Closed::class);
        $incident->save();
    }
}
