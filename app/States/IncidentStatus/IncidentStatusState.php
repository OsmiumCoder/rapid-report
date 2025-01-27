<?php

namespace App\States\IncidentStatus;

use App\StateTransitions\IncidentAssignedTransition;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class IncidentStatusState extends State
{
    public static function config() : StateConfig
    {
        return parent::config()->default(Opened::class)
            ->allowTransition(Opened::class, Assigned::class, IncidentAssignedTransition::class)
            ->allowTransition(Assigned::class, InReview::class)
            ->allowTransition(InReview::class, Assigned::class)
            ->allowTransition(InReview::class, Closed::class)
            ->allowTransition(Closed::class, Reopened::class)
            ->allowTransition(Reopened::class, Assigned::class, IncidentAssignedTransition::class)
            ;
    }

}
