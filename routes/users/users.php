<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\NotificationController;

Route::post('/auth_provider', [UserController::class, 'createAuthProvider']);
Route::post('/', [UserController::class, 'create']);

Route::group(['middleware' => ['auth.jwt']], function() {
	 
	Route::get('/',     [UserController::class, 'all']);
	Route::get('/{id}', [UserController::class, 'find']);
	Route::post('/allByHost', [UserController::class, 'byHost']);
	Route::post('/noParent',     [UserController::class, 'noParent']);
	Route::post('/delete/{id}', [UserController::class, 'delete']);
	Route::post('/{id}/image', [UserController::class, 'updateImage']);
	Route::post('/{id}', [UserController::class, 'update']);
	Route::post('/{id}/password', [UserController::class, 'updatePassword']);
	Route::post('/{id}/active', [UserController::class, 'updateActive']);

});



