<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register', "AuthenticationController@register");
Route::post('login', "AuthenticationController@login");

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'User found!',
            'user'    => $request->user(),
        ]);
    });
    Route::post('refresh-token', "AuthenticationController@refreshToken");
    Route::apiResource('users', "UserController");

});
