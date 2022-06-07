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
Route::post('/login', 'UserController@postLogin')->name('post_login');
Route::get('/logout', 'UserController@logout')->name('logout');

Route::group(['prefix' => 'account'], function () {
    Route::get('/register', 'UserController@register')->name('register_account');
    Route::get('/', 'UserController@list')->name('list_account');
});

Route::group(['prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@index')->name('list_customer');
    Route::get('/search', 'CustomerController@search')->name('search_customer');
    Route::get('/export/', 'CustomerController@export')->name('export_customer');
    Route::post('/import/', 'CustomerController@import')->name('import_customer');
});

Route::group(['prefix' => 'excel'], function () {
    Route::get('/import', 'CustomerController@index')->name('data_import');
    Route::get('/history', 'CustomerController@history')->name('data_import_history');
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'UserController@admin')->name('admin');
    // Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');
});
