<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function() { 
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::post('/editProfile', [AuthController::class, 'update']);
});
