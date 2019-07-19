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

Route::get('/home', function () {
	return view('welcome');
})->name('home');


Auth::routes();


Route::get('/admin/', 'DashboardController@index')->middleware('auth');

Route::get('/admin/account/', 'AccountController@index')->middleware('auth');
Route::get('/admin/account/create/', 'AccountController@create')->middleware('auth');
Route::post('/admin/account/', 'AccountController@store')->middleware('auth');
Route::get('/admin/account/{id}', 'AccountController@show')->middleware('auth');
Route::get('/admin/account/{id}/edit', 'AccountController@edit')->middleware('auth');
Route::put('/admin/account/{id}', 'AccountController@update')->middleware('auth');
Route::delete('/admin/account/{id}', 'AccountController@destroy')->middleware('auth');

Route::get('/admin/deposit/', 'DepositController@index')->middleware('auth');
Route::get('/admin/deposit/create/', 'DepositController@create')->middleware('auth');
Route::post('/admin/deposit/', 'DepositController@store')->middleware('auth');
Route::get('/admin/deposit/{id}', 'DepositController@show')->middleware('auth');
Route::get('/admin/deposit/{id}/edit', 'DepositController@edit')->middleware('auth');
Route::put('/admin/deposit/{id}', 'DepositController@update')->middleware('auth');
Route::delete('/admin/deposit/{id}', 'DepositController@destroy')->middleware('auth');

Route::get('/admin/user', 'UserController@index')->middleware('auth');

