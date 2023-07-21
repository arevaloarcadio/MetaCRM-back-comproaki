<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PasswordResetController;

Route::post('/', [PasswordResetController::class, 'create']);
Route::post('/recovery', [PasswordResetController::class, 'recovery']);
