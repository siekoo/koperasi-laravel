<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/', 'DashboardController@index');

Route::get('/admin/account/', 'AccountController@index');
Route::get('/admin/account/create/', 'AccountController@create');
Route::post('/admin/account/', 'AccountController@store');
Route::get('/admin/account/{id}', 'AccountController@show');
Route::get('/admin/account/{id}/edit', 'AccountController@edit');
Route::put('/admin/account/{id}', 'AccountController@update');
Route::delete('/admin/account/{id}', 'AccountController@destroy');

Route::get('/admin/deposit/', 'DepositController@index');
Route::get('/admin/deposit/create/', 'DepositController@create');
Route::post('/admin/deposit/', 'DepositController@store');
Route::get('/admin/deposit/{id}', 'DepositController@show');
Route::get('/admin/deposit/{id}/edit', 'DepositController@edit');
Route::put('/admin/deposit/{id}', 'DepositController@update');
Route::delete('/admin/deposit/{id}', 'DepositController@destroy');
