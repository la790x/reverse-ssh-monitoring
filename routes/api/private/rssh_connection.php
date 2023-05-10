<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'rssh-connections', 'as' => 'api.private.rssh-connection.', 'middleware' => []], function () {
    Route::put('terminate/{id}', function (Request $request, $id) {
        return app('app.action.api.private.rssh-connection.terminate')->handle($request, $id);
    })->name('terminate');
});
