<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'UserController@index')->name('home');

Route::get('/login', 'UserController@login')->name('login');

Route::group(['prefix' => 'account'], function () {
    Route::get('/register', 'UserController@register')->name('register_account');
    Route::get('/', 'UserController@list')->name('list_account');
});

Route::group(['prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@index')->name('list_customer');
});

Route::group(['prefix' => 'excel'], function () {
    Route::get('/import', 'ExcelController@index')->name('data_import');
    Route::get('/history', 'ExcelController@history')->name('data_import_history');
});
