<?php

/*
|--------------------------------------------------------------------------
| Third-Party System API Routes
|--------------------------------------------------------------------------
|
| these routes provide interface for third party system web hooks to synchronise data
|
*/

use App\Http\Controllers\ThirdPartyHooks\UserController;
use Illuminate\Support\Facades\Route;

Route::post("/user",[UserController::class,'updateOrStore']);
Route::delete('/user',[UserController::class,'destroy']);
Route::get('/user',[UserController::class,'index']);

