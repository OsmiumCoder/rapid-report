<?php

use Illuminate\Support\Facades\Route;


Route::permanentRedirect('/', '/login');


require __DIR__ . '/auth.php';
require __DIR__ . '/incidents.php';
require __DIR__ . '/investigations.php';
require __DIR__ . '/notifications.php';
require __DIR__ . '/root-cause-analyses.php';
require __DIR__ . '/reports.php';
require __DIR__ . '/users.php';
require __DIR__ . '/dashboard.php';
