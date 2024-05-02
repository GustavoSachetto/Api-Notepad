<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CsrfController;

Route::group([
    'prefix' => 'v1'
], function(){
    Route::post('users/validate', [UserController::class, 'validate']);
    Route::post('users', [UserController::class, 'store']);

    Route::group([
        'prefix'=>'notes'
    ], function(){
        Route::post('', [NoteController::class, 'store']);
        Route::get('/{id?}', [NoteController::class, 'read']);
        Route::put('/{id?}', [NoteController::class, 'update']);
        Route::delete('/{id?}', [NoteController::class, 'delete']);
    });

    Route::get('/getCSRF', [CsrfController::class, 'token']);
});

