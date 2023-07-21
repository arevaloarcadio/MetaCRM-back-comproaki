<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController;


Route::group(['middleware' => ['auth.jwt']], function() { 
	Route::get('/',     [HostController::class, 'all']);
	Route::get('/{id}', [HostController::class, 'find']);
	Route::post('/',    [HostController::class, 'create']);
	Route::post('/{id}', [HostController::class, 'update']);
	Route::post('/delete/{id}', [HostController::class, 'delete']);
});