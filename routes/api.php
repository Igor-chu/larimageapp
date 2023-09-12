<?php

use App\Http\Controllers\Post\IndexController;
use App\Http\Controllers\Post\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'posts', 'namespace' => 'App\Http\Controllers\Post'], function() {
    Route::get('/', IndexController::class);
    Route::post('/', StoreController::class);
});
