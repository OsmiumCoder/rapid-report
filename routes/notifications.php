<?php

use App\Http\Controllers\NotificationController;

Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
Route::delete('/notifications/all', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
