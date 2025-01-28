<?php

namespace App\StorableEvents\Incident;

use App\Models\Incident;
use App\States\IncidentStatus\Reopened;
use App\StorableEvents\StoredEvent;

class IncidentReopened extends StoredEvent
{
    public function handle() {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->status->transitionTo(Reopened::class);
        $incident->supervisor_id = null;
        $incident->save();
    }
}
