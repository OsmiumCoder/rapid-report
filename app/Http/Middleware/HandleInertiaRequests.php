<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        $notifications = $user ?
            $user
                ->notifications()
                ->paginate(10, pageName: 'notifications')
            : null;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
            ],
            'notifications' => $notifications ? inertia()->merge($notifications->items()) : null,
            'notifications_paginator' => $notifications ? $notifications->toArray() : null,
            'ziggy' => fn () => [
                ...(new Ziggy)->toArray(),
                'location' => $request->url(),
            ],
        ];
    }
}
