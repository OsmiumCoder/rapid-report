<?php

namespace App\Http\Controllers\User;

use App\Enum\RolesEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\StorableEvents\User\UserRoleUpdated;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserRoleController extends Controller
{
    /**
     * Update the specified User Role in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('updateRole', $user);

        $request->validate([
            'role' => [Rule::enum(RolesEnum::class)],
        ]);

        $role = $request->enum('role', RolesEnum::class);

        $event = new UserRoleUpdated(
            user_id: $user->id,
            role: $role,
        );

        event($event);

        return back();
    }
}
