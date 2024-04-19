<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;

Route::group([
    'prefix' => 'v1',
], function(){
    Route::resource('/' , UserController::class);
    Route::resource('/notes' , NotesController::class);
});