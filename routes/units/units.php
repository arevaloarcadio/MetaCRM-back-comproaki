<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnitController;

Route::group(['middleware' => ['auth.jwt']], function() { 
	Route::get('/',     [UnitController::class, 'all']);
	Route::get('/{id}', [UnitController::class, 'find']);
	Route::post('/',    [UnitController::class, 'create']);
	Route::post('/{id}', [UnitController::class, 'update']);
	Route::post('/delete/{id}', [UnitController::class, 'delete']);
});
