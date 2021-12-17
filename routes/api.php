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
Route::prefix('v1')->group(function() {
    Route::middleware('cors')->group(function () {
        Route::post('/auth/login', 'API\AuthController@login');
        Route::post('/auth/register', 'API\AuthController@register');
        Route::post('auth/refresh', 'API\AuthController@refresh');

        Route::middleware('auth:api')->group(function () {
            Route::get('/auth/user', 'API\AuthController@user');
            Route::post('/auth/logout', 'API\AuthController@logout');

            Route::get('/admin/home', 'API\HomeController@index');
        });
    });
});
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
