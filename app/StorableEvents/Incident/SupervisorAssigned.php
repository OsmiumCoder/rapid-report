<?php

namespace App\StorableEvents\Incident;

use App\Models\Incident;
use App\States\IncidentStatus\Assigned;
use App\StorableEvents\StoredEvent;

class SupervisorAssigned extends StoredEvent
{
    public function __construct(
        public int $supervisor_id,
    ) {
    }

    public function handle()
    {
        $incident = Incident::find($this->aggregateRootUuid());
        $incident->supervisor_id = $this->supervisor_id;
        $incident->status->transitionTo(Assigned::class);
        $incident->save();
    }
}
