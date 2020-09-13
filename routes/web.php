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
Route::get('change-language/{language}', 'LangController@changeLanguage')->name('changeLanguage');

Route::group(['middleware' => 'locale'], function () {
    Route::group(['domain' => env('APP_URL'), 'namespace' => 'Web'], function () {
        Route::resource('/', 'RequestController')->only([
            'index',
            'store',
        ]);
    });
    
    Route::group(['domain' => env('APP_ADMIN_URL')], function () {
        
    });
    
    Route::group(['domain' => env('APP_AGENCY_URL'), 'namespace' => 'Agency', 'as' => 'agency.'], function () {
        Route::resource('signup', 'AgencyController')->only([
            'index',
            'store',
        ]);
        Route::get('login', 'AgencyController@getLogin')->name('getLogin');
        Route::post('login', 'AgencyController@postLogin')->name('postLogin');
        Route::group(['middleware' => 'agency'], function () {
            Route::post('logout', 'AgencyController@postLogout')->name('postLogout');
            Route::resource('requests', 'RequestController'); 
            Route::resource('contracts', 'ContractController')->only([
                'index',
                'show',
                'destroy',
            ]); 
        });
    });
    
    Route::group(['domain' => env('APP_HOST_URL'), 'namespace' => 'Host', 'as' => 'host.'], function () {
        Route::resource('signup', 'HostController')->only([
            'index',
            'store',
        ]);
        Route::get('login', 'HostController@getLogin')->name('getLogin');
        Route::post('login', 'HostController@postLogin')->name('postLogin');
        Route::group(['middleware' => 'host'], function () {
            Route::get('/', 'HostController@getDetail')->name('getDetail');
            Route::put('/{id}', 'HostController@putDetail')->name('putDetail');
            Route::delete('/{id}', 'HostController@deleteDetail')->name('deleteDetail');
            Route::post('/', 'HostController@postDetail')->name('postDetail');
            Route::post('logout', 'HostController@postLogout')->name('postLogout');
            Route::group(['middleware' => 'host_detail'], function () {
                Route::resource('contracts', 'ContractController');
                Route::resource('requests', 'RequestController')->only([
                    'index',
                    'show',
                    'update',
                ]);
            });
        });
    });
});
