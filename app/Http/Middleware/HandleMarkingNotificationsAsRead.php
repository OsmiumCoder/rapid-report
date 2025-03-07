<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleMarkingNotificationsAsRead
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->query('notification') !== null) {
            auth()->user()->unreadNotifications()->find($request->query('notification'))?->markAsRead();
        }

        return $next($request);
    }
}
