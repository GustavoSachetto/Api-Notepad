<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;

Route::group([
    'prefix' => 'v1'
], function(){
    Route::apiResource('/' , UserController::class);
    Route::apiResource('/notes' , NotesController::class);

    Route::get('/getCSRF' , function(){
        return csrf_token();
    });
});
