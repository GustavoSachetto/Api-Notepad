<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CsrfController;

Route::group([
    'prefix' => 'v1'
], function(){
    Route::post('/validate', [UserController::class, 'validate']);
    Route::post('/create', [UserController::class, 'store']);

    Route::group([
        'prefix'=>'notes'
    ], function(){
        Route::post('/create', [NoteController::class, 'store']);
        Route::post('/read', [NoteController::class, 'read']);
        Route::put('/edit/{id?}', [NoteController::class, 'update']);
        Route::delete('/delete/{id?}', [NoteController::class, 'delete']);
    });

    Route::get('/getCSRF', [CsrfController::class, 'token']);
});

