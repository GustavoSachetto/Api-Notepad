<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::middleware('jwt.auth')->post('', [NoteController::class, 'store']);
Route::middleware('jwt.auth')->get('', [NoteController::class, 'read']);
Route::middleware('jwt.auth')->put('/{id?}', [NoteController::class, 'update']);
Route::middleware('jwt.auth')->delete('/{id?}', [NoteController::class, 'delete']);
Route::middleware('jwt.auth')->get('/search/{title}', [NoteController::class, 'search']);