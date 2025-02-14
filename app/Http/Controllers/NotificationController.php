<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function markAllRead(Request $request): void
    {
        auth()->user()->notifications->markAsRead();
        response()->json(['status' => 'success']);
    }

    public function destroyAll(Request $request): void
    {
        auth()->user()->notifications()->delete();
        response()->json(['status' => 'success']);
    }

    public function destroy(string $notification): void
    {
        auth()->user()->notifications()->find($notification)->delete();
        response()->json(['status' => 'success']);
    }
}
