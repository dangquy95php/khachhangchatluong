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
// Clear application cache:
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return 'Application cache has been cleared';
});

//Clear route cache:
Route::get('/route-cache', function() {
	Artisan::call('route:cache');
    return 'Routes cache has been cleared';
});

//Clear config cache:
Route::get('/config-cache', function() {
 	Artisan::call('config:cache');
 	return 'Config cache has been cleared';
}); 

// Clear view cache:
Route::get('/view-clear', function() {
    Artisan::call('view:clear');
    return 'View cache has been cleared';
});
//Clear Config cache:
Route::get('/refresh-seed', function() {
    $exitCode = Artisan::call('migrate:refresh --seed');
    return '<h1>Clear Config cleared</h1>';
});


Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@postLogin')->name('post_login');

Route::group(['auth' => '', 'prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@index')->name('list_customer');
    Route::get('/search', 'CustomerController@search')->name('search_customer');
    Route::get('/delete', 'CustomerController@delete')->name('delete_customers');
    
//     Route::get('/export/', 'CustomerController@export')->name('export_customer');
//     Route::post('/import/', 'CustomerController@import')->name('import_customer');

    Route::get('/detail/{id}', 'HomeController@detail')->name('customer_detail');
    Route::post('/update', 'HomeController@update')->name('customer_update');
    Route::post('/save', 'HomeController@save')->name('customer_save');

    Route::get('/logout', 'UserController@logout')->name('logout');
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
        Route::get('/customer', 'AreaController@customerByArea')->name('customer_by_area');
        Route::post('/customer', 'AreaController@postCustomerByArea')->name('post_customer_by_area');
        Route::get('/add-area-to-user', 'AreaController@addAreaToUser')->name('add_area_to_user');
        Route::post('/add-area-to-user', 'AreaController@postAddAreaToUser')->name('post_add_area_to_user');
        Route::get('/del-area-to-user/{id}', 'AreaController@delAreaToUser')->name('del_area_to_user');

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
        Route::post('/import', 'ExcelController@postImport')->name('post_data_import');
        Route::get('/history', 'ExcelController@history')->name('data_import_history');
    });
});
