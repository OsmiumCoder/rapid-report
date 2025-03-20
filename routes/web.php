<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

Route::permanentRedirect('/', '/login');

Route::get('/auth/redirect', function () {
    return Socialite::driver('microsoft')
        ->with(['hd' => 'upei.ca'])
        ->redirect();
})->name('redirect.microsoft');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('microsoft')->user();

    $user = User::withTrashed()->updateOrCreate([
        'email' => $user->getEmail(),
    ], [
        'name' => $user->getName(),
        'email' => $user->getEmail(),
        'phone' => $user->mobilePhone,
        'deleted_at' => null,
    ]);

    Auth::login($user);

    return redirect(route('dashboard', absolute: false));
})->name('callback.microsoft');


require __DIR__ . '/auth.php';
require __DIR__ . '/incidents.php';
require __DIR__ . '/investigations.php';
require __DIR__ . '/notifications.php';
require __DIR__ . '/root-cause-analyses.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/users.php';
require __DIR__ . '/dashboard.php';
