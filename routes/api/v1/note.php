<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::post('', [NoteController::class, 'store']);
Route::get('/{id?}', [NoteController::class, 'read']);
Route::put('/{id?}', [NoteController::class, 'update']);
Route::delete('/{id?}', [NoteController::class, 'delete']);