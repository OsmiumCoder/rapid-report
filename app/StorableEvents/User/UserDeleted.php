<?php

namespace App\StorableEvents\User;

use App\Models\Incident;
use App\Models\User;
use App\States\IncidentStatus\Assigned;
use App\States\IncidentStatus\Opened;
use App\StorableEvents\StoredEvent;

class UserDeleted extends StoredEvent
{
    public function __construct(
        public int $user_id,
    ) {
    }

    public function handle(): void
    {
        $user = User::find($this->user_id);

        $user->incidents->each(function (Incident $incident) {
            if ($incident->status::class == Assigned::class) {
                $incident->supervisor_id = null;
                $incident->status->transitionTo(Opened::class);
                $incident->save();
            }
        });

        // Since we are using soft deletes supervisor and admins should be set to user
        // in the event they sign in via oauth they will be restored but only as a user.
        $user->syncRoles('user');

        $user->delete();
    }
}
