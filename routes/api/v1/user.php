<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::post('', [UserController::class, 'store']);
Route::post('/validate', [UserController::class, 'validate']);