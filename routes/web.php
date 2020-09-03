<?php

use Illuminate\Support\Facades\Route;
use RealRashid\SweetAlert\Facades\Alert;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['domain' => env('APP_URL'), 'namespace' => 'Web'], function () {
    Route::resource('/', 'RequestController')->only([
        'index',
        'store',
    ]);
});

Route::group(['domain' => env('APP_ADMIN_URL')], function () {
    
});

Route::group(['domain' => env('APP_AGENCY_URL'), 'namespace' => 'Agency'], function () {
    Route::resource('/signup', 'AgencyController')->only([
        'index',
        'store',
    ]);
    Route::get('/login', 'AgencyController@getLogin')->name('agency.getLogin');
    Route::post('/login', 'AgencyController@postLogin')->name('agency.postLogin');
    Route::post('/logout', 'AgencyController@postLogout')->name('agency.postLogout');
    Route::group(['middleware' => 'agency'], function () {
        Route::resource('requests', 'RequestController');   
    });
});

Route::group(['domain' => env('APP_HOST_URL'), 'namespace' => 'Host'], function () {
    Route::resource('/signup', 'HostController')->only([
        'index',
        'store',
    ]);
    Route::get('/login', 'HostController@getLogin')->name('host.getLogin');
    Route::post('/login', 'HostController@postLogin')->name('host.postLogin');
    Route::post('/logout', 'HostController@postLogout')->name('host.postLogout');
    Route::group(['middleware' => 'host'], function () {
        Route::resource('contracts', 'ContractController');  
    });
});
