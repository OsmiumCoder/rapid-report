<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function markAllRead(): RedirectResponse
    {
        auth()->user()->notifications->markAsRead();
        return back();
    }

    public function destroyAll(): RedirectResponse
    {
        auth()->user()->notifications()->delete();
        return back();
    }

    public function destroy(string $notification): RedirectResponse
    {
        auth()->user()->notifications()->find($notification)->delete();
        return back();
    }
}
