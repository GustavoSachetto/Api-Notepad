<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware('jwt.auth')->post('', [NoteController::class, 'store']);
Route::middleware('jwt.auth')->get('/{id?}', [NoteController::class, 'read']);
Route::middleware('jwt.auth')->put('/{id?}', [NoteController::class, 'update']);
Route::middleware('jwt.auth')->delete('/{id?}', [NoteController::class, 'delete']);