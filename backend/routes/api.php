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
Route::group(['middleware' => ['api', 'return-json'], 'namespace' => '\App\Http\Controllers'], function () {
    Route::get('/posts', 'ApiController@posts');
    Route::post('/posts/new', 'ApiController@new');
});
