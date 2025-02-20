<?php

namespace App\Http\Controllers\User;

use App\Enum\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\StorableEvents\User\UserCreated;
use App\StorableEvents\User\UserDeleted;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'upei_id' => ['required', 'string'],
            'phone' => ['sometimes', 'nullable', 'string'],
            'role' => ['required', Rule::enum(RolesEnum::class)]
        ]);

        $event = new UserCreated(
            name: $request->name,
            email: $request->email,
            password: Hash::make($request->password),
            upei_id: $request->upei_id,
            phone: $request->phone,
            role: $request->enum('role', RolesEnum::class),
        );

        event($event);

        return back();
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $event = new UserDeleted(
            user_id: $user->id
        );

        event($event);

        return back();
    }
}
