<?php

namespace App\States\IncidentStatus;

use Spatie\ModelStates\Exceptions\InvalidConfig;
use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class IncidentStatusState extends State
{
    /**
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()->default(Opened::class)
            ->allowTransition(Assigned::class, Opened::class)
            ->allowTransition(Assigned::class, InReview::class)
            ->allowTransition(InReview::class, Returned::class)
            ->allowTransition(Returned::class, InReview::class)
            ->allowTransition(Closed::class, Reopened::class)
            ->allowTransition(Reopened::class, Assigned::class)
            ->allowTransition([Opened::class, Assigned::class, Reopened::class, InReview::class, Returned::class], Closed::class)
            ->allowTransition([Opened::class, Assigned::class], Assigned::class);
    }
}
