<?php

use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Notification\NotificationMessageController;

Route::put('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
Route::delete('/notifications/all', [NotificationController::class, 'destroyAll'])->name('notifications.destroy-all');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

Route::put('/notifications/update-message/{notification_message}', [NotificationMessageController::class, 'update'])->name('notifications.update-message');
