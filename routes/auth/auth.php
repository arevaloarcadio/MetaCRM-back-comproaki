<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/provider/login', [AuthController::class, 'registerProvider']);


Route::group(['middleware' => ['auth:sanctum']], function() { 
	Route::post('/logout', [AuthController::class, 'logout']);
	Route::post('/editProfile', [AuthController::class, 'update']);
});
