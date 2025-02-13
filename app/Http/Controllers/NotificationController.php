<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = auth()->user()->notifications()->simplePaginate(10, $page=$request->int('page'));

        return response()->json($notifications);
    }
}
