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
Route::group(['namespace' => 'Api'], function () {
    Route::resource('car-types', 'CarTypeController')->only([
        'index'
    ]);
    Route::resource('province-airport', 'ProvinceAirportController')->only([
        'index', 
        'show',
    ]);
    Route::get('province-search', 'ProvinceController@searchByName');
    Route::post('calculate-price', 'RequestController@calculatePrice');
});
