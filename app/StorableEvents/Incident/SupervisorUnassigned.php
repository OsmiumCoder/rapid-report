<?php

namespace App\StorableEvents\Incident;

use App\Models\Incident;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\StoredEvent;

class SupervisorUnassigned extends StoredEvent
{
    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->supervisor_id = null;
        $incident->status->transitionTo(Opened::class);
        $incident->save();
    }
}
