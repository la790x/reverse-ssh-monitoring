<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('public')->group(__DIR__.'/api/public/ping.php');
Route::prefix('private')->group(__DIR__.'/api/private/rssh_connection.php');
