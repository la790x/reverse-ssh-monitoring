<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pings', 'as' => 'api.private.ping.', 'middleware' => []], function () {
    Route::post('/', function (Request $request) {
        return app('app.action.api.public.ping.store')->handle($request);
    })->name('store');
});
