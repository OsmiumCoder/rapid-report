<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\SMSNotification;
use Illuminate\Http\Request;

class SMSNotificationController extends Controller
{
    public function sendSMS(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        $user = auth()->user();

        if (!$user->phone) {
            return response()->json(['error' => 'User missing phone number'], 400);
        }

        else if ($user && $user->phone) {
            $user->notify(new SMSNotification());
            return response()->json(['message' => 'SMS sent successfully!']);
        }

        return response()->json(['error' => 'User not found or missing phone number'], 400);
    }
}
