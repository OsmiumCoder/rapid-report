<?php

namespace App\Http\Controllers\User;

use App\Enum\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use App\StorableEvents\User\UserDeleted;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'upei_id' => ['sometimes', 'nullable', 'string'],
            'phone' => ['sometimes', 'nullable', 'string'],
            'role' => ['required', Rule::enum(RolesEnum::class)],
            'incident_id' => ['sometimes', 'nullable', 'string'],
        ]);

        $event = new UserCreated(
            name: $request->name,
            email: $request->email,
            upei_id: $request->upei_id,
            phone: $request->phone,
            role: $request->enum('role', RolesEnum::class),
            incident_id: $request->incident_id,
        );

        event($event);

        return back();
    }

    /**
     * Remove the specified user from storage.
     * @throws AuthorizationException
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->authorize('delete', $user);

        $event = new UserDeleted(
            user_id: $user->id
        );

        event($event);

        return back();
    }
}
