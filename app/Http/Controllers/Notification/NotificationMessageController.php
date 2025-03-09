<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\NotificationMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NotificationMessageController extends Controller
{
    public function update(Request $request, NotificationMessage $notificationMessage): RedirectResponse
    {
        $this->authorize('update', $notificationMessage);

        $validated = $request->validate([
           'message' => 'required',
        ]);

        $notificationMessage->message = $validated['message'];
        $notificationMessage->save();

        return back();
    }
}
