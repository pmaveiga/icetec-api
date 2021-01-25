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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});

Route::group(['middleware' => 'api', 'prefix' => 'applicant'], function () {
    Route::get('/', 'ApplicantController@getAll');
    Route::get('/{id}', 'ApplicantController@get');
    Route::get('/find/{technology}', 'ApplicantController@find');
    Route::post('/', 'ApplicantController@save');
    Route::put('/{id}', 'ApplicantController@put');
    Route::delete('/{id}', 'ApplicantController@delete');
});

Route::group(['middleware' => 'api', 'prefix' => 'technology'], function () {
    Route::get('/', 'TechnologyController@getAll');
});
