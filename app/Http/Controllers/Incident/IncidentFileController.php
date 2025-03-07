<?php

namespace App\Http\Controllers\Incident;

use App\Aggregates\IncidentAggregateRoot;
use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Incident;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File as FileRules;
use Symfony\Component\HttpFoundation\StreamedResponse;

class IncidentFileController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function upload(Request $request, Incident $incident): RedirectResponse
    {
        $this->authorize('provideFollowUp', $incident);

        $request->validate([
            'files' => 'required|array',
            'files.*' => [
                'required',
                FileRules::types(['pdf', 'doc', 'docx', 'txt', 'rtf', 'jpeg', 'jpg', 'png'])
                    ->max('50mb')
            ],
        ], [
            'files.required' => 'You must upload at least one file.',
            'files.*.required' => 'Each file is required.',
            'files.*.max' => 'File must not exceed 50 MB.',
            'files.*' => 'Only pdf, doc, docx, txt, rtf, jpeg, jpg, and png files are allowed.',
        ]);

        $files = $request->file('files');

        IncidentAggregateRoot::retrieve($incident->id)
            ->uploadFiles($files)
            ->persist();

        return back();
    }

    public function download(Incident $incident, File $file): StreamedResponse
    {
        $this->authorize('downloadFiles', [Incident::class, $file]);

        return Storage::download($file->name, $file->original_name);
    }
}
