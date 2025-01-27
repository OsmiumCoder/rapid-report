<?php

namespace App\StateTransitions;

use App\Models\Incident;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Opened;
use App\States\IncidentStatus\Reopened;
use Spatie\ModelStates\Transition;

class IncidentAssignedTransition extends Transition
{
    private Incident $incident;
    private int $supervisorId;

    public function __construct(Incident $incident, int $supervisorId) {
        $this->incident = $incident;
        $this->supervisorId = $supervisorId;
    }

    public function canTransition(): bool
    {
        return $this->incident->status->equals(Opened::class) || $this->incident->status->equals(Reopened::class);

    }

    public function handle() {
        $this->incident->status = new Assigned($this->incident);
        $this->incident->supervisor_id = $this->supervisorId;
        $this->incident->save();

        // TODO: Notify supervisor of assignment
    }
}
