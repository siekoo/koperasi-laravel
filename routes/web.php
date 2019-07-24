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

Route::get( '/admin/', 'DashboardController@index' )->middleware( 'auth' );

Route::get( '/admin/account/', 'AccountController@index' )->middleware( 'auth' )->name('admin.account');
Route::get( '/admin/account/create/', 'AccountController@create' )->middleware( 'auth' )->name( 'admin.account.create' );
Route::post( '/admin/account/', 'AccountController@store' )->middleware( 'auth' );
Route::get( '/admin/account/{id}', 'AccountController@show' )->middleware( 'auth' )->name('admin.account.show');
Route::get( '/admin/account/{id}/edit', 'AccountController@edit' )->middleware( 'auth' );
Route::put( '/admin/account/{id}', 'AccountController@update' )->middleware( 'auth' );
Route::delete( '/admin/account/{id}', 'AccountController@destroy' )->middleware( 'auth' );

Route::get( '/admin/deposit/', 'DepositController@index' )->middleware( 'auth' )->name('admin.deposit');
Route::get( '/admin/deposit/weekly/', 'DepositController@weekly' )->middleware( 'auth' )->name( 'admin.deposit.weekly' );
Route::get( '/admin/deposit/create/', 'DepositController@create' )->middleware( 'auth' )->name( 'admin.deposit.create' );
Route::post( '/admin/deposit/', 'DepositController@store' )->middleware( 'auth' );
Route::get( '/admin/deposit/{id}', 'DepositController@show' )->middleware( 'auth' );
Route::get( '/admin/deposit/{id}/edit', 'DepositController@edit' )->middleware( 'auth' );
Route::put( '/admin/deposit/{id}', 'DepositController@update' )->middleware( 'auth' );
Route::delete( '/admin/deposit/{id}', 'DepositController@destroy' )->middleware( 'auth' );

Route::get( '/admin/expense/', 'ExpenseController@index' )->middleware( 'auth' )->name('admin.expense');
Route::get( '/admin/expense/create/', 'ExpenseController@create' )->middleware( 'auth' )->name( 'admin.expense.create' );
Route::post( '/admin/expense/', 'ExpenseController@store' )->middleware( 'auth' );
Route::get( '/admin/expense/{id}', 'ExpenseController@show' )->middleware( 'auth' );
Route::get( '/admin/expense/{id}/edit', 'ExpenseController@edit' )->middleware( 'auth' );
Route::put( '/admin/expense/{id}', 'ExpenseController@update' )->middleware( 'auth' );
Route::delete( '/admin/expense/{id}', 'ExpenseController@destroy' )->middleware( 'auth' );


Route::get( '/admin/user', 'UserController@index' )->middleware( 'auth' );
Route::get( '/admin/user/create', 'UserController@create' )->middleware( 'auth' );
Route::get( '/admin/user/history', 'UserController@history' )->middleware( 'auth' );
