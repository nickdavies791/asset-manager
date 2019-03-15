<?php

use App\Type;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user/schools', function (Request $request) {
	return $request->user()->schools;
});

Route::middleware('auth:api')->get('/categories', function (Request $request, Type $type) {
	return $type->find($request->type)->categories;
});

Route::middleware('auth:api')->get('/types', function (Type $type) {
	return $type->all();
});