<?php namespace Acme\Jarvis;

use Illuminate\Support\Facades\Route;
use Acme\Jarvis\Http\Controllers\ChatController;

Route::group(['prefix' => 'api/jarvis', 'namespace' => 'Acme\Jarvis\Http\Controllers'], function() {
    Route::post('handle-message', [ChatController::class, 'handleMessage']);
});