<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File as FileRules;

class IncidentFileController extends Controller
{
    public function upload(Request $request, Incident $incident)
    {
        $this->authorize('provideFollowUp', $incident);

        $request->validate([
            'files' => 'required|array',
            'files.*' => [
                'required',
                FileRules::types(['pdf', 'doc', 'docx', 'txt', 'rtf', 'jpeg', 'jpg', 'png'])
                    ->max('100mb')
            ],
        ]);

        $files = $request->file('files');

        IncidentAggregateRoot::retrieve($incident->id)
            ->uploadFiles($files)
            ->persist();

        return back();
    }

    public function download(Incident $incident, File $file)
    {

    }
}
