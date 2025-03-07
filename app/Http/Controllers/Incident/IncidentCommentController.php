<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Data\CommentData;
use App\Http\Controllers\Controller;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;

class IncidentCommentController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function __invoke(Incident $incident, CommentData $commentData): RedirectResponse
    {
        $this->authorize('addComment', $incident);

        IncidentAggregateRoot::retrieve($incident->id)
            ->addComment($commentData)
            ->persist();

        return back();
    }
}
