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

Route::group(['prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@index')->name('list_customer');
    Route::get('/search', 'CustomerController@search')->name('search_customer');
    Route::get('/export/', 'CustomerController@export')->name('export_customer');
    Route::post('/import/', 'CustomerController@import')->name('import_customer');
});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/', 'UserController@admin')->name('admin');
    // Route::get('/dashboard', 'UserController@dashboard')->name('dashboard');

    Route::group(['prefix' => 'area'], function () {
        Route::get('/', 'AreaController@index')->name('index_area');
        Route::get('/edit/{id}', 'AreaController@edit')->name('edit_area');
        Route::post('/edit/{id}', 'AreaController@postEdit')->name('post_edit_area');
        Route::post('/create', 'AreaController@create')->name('create_area');
        Route::get('/delete/{id}', 'AreaController@delete')->name('delete_area');

    });

    Route::group(['prefix' => 'account'], function () {
        Route::get('/', 'UserController@list')->name('list_account');
        Route::get('/create', 'UserController@create')->name('create_account');
        Route::post('/create', 'UserController@postCreate')->name('post_create_account');
        Route::get('/edit/{id}', 'UserController@edit')->name('edit_account');
        Route::post('/edit/{id}', 'UserController@postEdit')->name('post_edit_account');
        Route::get('/delete/{id}', 'UserController@delete')->name('delete_account');
    });

    Route::group(['prefix' => 'excel'], function () {
        Route::get('/import', 'ExcelController@import')->name('data_import');
        Route::get('/history', 'ExcelController@history')->name('data_import_history');
    });
});
