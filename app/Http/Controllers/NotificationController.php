<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllRead(Request $request)
    {
        auth()->user()->notifications->markAsRead();
        return back();
    }

    public function destroyAll(Request $request)
    {
        auth()->user()->notifications()->delete();
        return back();
    }

    public function destroy(string $notification)
    {
        auth()->user()->notifications()->find($notification)->delete();
        return back();
    }
}
