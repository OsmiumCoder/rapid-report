<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => [
                function (string $attribute, mixed $value, Closure $fail) {
                    // If the provided value is null, check if the user's current password is also null
                    if (is_null($value)) {
                        if (!is_null(Auth::user()->password)) {
                            $fail('The current password is incorrect.');
                        }
                    } else {
                        // Otherwise, validate the password using Hash::check
                        if (!Hash::check($value, Auth::user()->password)) {
                            $fail('The current password is incorrect.');
                        }
                    }
                },
            ],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back();
    }
}
