<?php

namespace App\StorableEvents\Incident;

use App\Models\Incident;
use App\StorableEvents\StoredEvent;

class SupervisorAssigned extends StoredEvent
{
    public function __construct(int $supervisor_id, string $incident_id) {}

    public function handle()
    {
        $incident = Incident::find($this->incident_id);
        $incident->supervisor_id = $this->supervisor_id;
        $incident->save();
    }
}
