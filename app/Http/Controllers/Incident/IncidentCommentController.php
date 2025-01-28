<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\CommentData;
use App\Http\Controllers\Controller;
use App\Models\Incident;

class IncidentCommentController extends Controller
{
    public function __invoke(Incident $incident, CommentData $commentData)
    {
        $this->authorize('addComment', $incident);

        IncidentAggregateRoot::retrieve($incident->id)
            ->addComment($commentData)
            ->persist();

        return back();
    }
}
