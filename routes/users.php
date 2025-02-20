<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\UserRoleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class)->only(['store', 'destroy']);

    Route::patch('users/{user}/update-role', [UserRoleController::class, 'update'])->name('users.update-role');
});
