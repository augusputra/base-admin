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

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@sendLogin');
Route::post('/logout',function(){
	Session::flush();
	return redirect()->route('login');
})->name('logout');

Route::group([
    'middleware' => 'adminauth',
], function($router) {
    Route::get('/', 'DashboardController@index')->name('admin.dashboard');

    Route::group([
        'prefix' => 'categories'
    ], function($router){
        Route::get('/', 'CategoriesController@index')->name('admin.categories');
        Route::get('/form', 'CategoriesController@form')->name('admin.categories.form');
        Route::post('/create', 'CategoriesController@create')->name('admin.categories.create');
        Route::get('/form/{param}', 'CategoriesController@form')->name('admin.categories.form_update');
        Route::post('/update/{param}', 'CategoriesController@update')->name('admin.categories.update');
        Route::get('/detail/{param}', 'CategoriesController@detail')->name('admin.categories.detail');
        Route::get('/delete/{param}', 'CategoriesController@delete')->name('admin.categories.delete');
    });

    Route::group([
        'prefix' => 'services'
    ], function($router){
        Route::get('/', 'ServicesController@index')->name('admin.services');
        Route::get('/form', 'ServicesController@form')->name('admin.services.form');
        Route::post('/create', 'ServicesController@create')->name('admin.services.create');
        Route::get('/form/{param}', 'ServicesController@form')->name('admin.services.form_update');
        Route::post('/update/{param}', 'ServicesController@update')->name('admin.services.update');
        Route::get('/detail/{param}', 'ServicesController@detail')->name('admin.services.detail');
        Route::get('/delete/{param}', 'ServicesController@delete')->name('admin.services.delete');
    });

    Route::group([
        'prefix' => 'blogs'
    ], function($router){
        Route::get('/', 'BlogsController@index')->name('admin.blogs');
        Route::get('/form', 'BlogsController@form')->name('admin.blogs.form');
        Route::post('/create', 'BlogsController@create')->name('admin.blogs.create');
        Route::get('/form/{param}', 'BlogsController@form')->name('admin.blogs.form_update');
        Route::post('/update/{param}', 'BlogsController@update')->name('admin.blogs.update');
        Route::get('/detail/{param}', 'BlogsController@detail')->name('admin.blogs.detail');
        Route::get('/delete/{param}', 'BlogsController@delete')->name('admin.blogs.delete');
    });

    Route::group([
        'prefix' => 'banners'
    ], function($router){
        Route::get('/', 'BannersController@index')->name('admin.banners');
        Route::get('/form', 'BannersController@form')->name('admin.banners.form');
        Route::post('/create', 'BannersController@create')->name('admin.banners.create');
        Route::get('/form/{param}', 'BannersController@form')->name('admin.banners.form_update');
        Route::post('/update/{param}', 'BannersController@update')->name('admin.banners.update');
        Route::get('/detail/{param}', 'BannersController@detail')->name('admin.banners.detail');
        Route::get('/delete/{param}', 'BannersController@delete')->name('admin.banners.delete');
    });

    Route::group([
        'prefix' => 'users'
    ], function($router){
        Route::get('/', 'UsersController@index')->name('admin.users');
        Route::get('/form', 'UsersController@form')->name('admin.users.form');
        Route::get('/form/{param}', 'UsersController@form')->name('admin.users.form_update');
        Route::post('/update/{param}', 'UsersController@update')->name('admin.users.update');
        Route::get('/detail/{param}', 'UsersController@detail')->name('admin.users.detail');
        Route::get('/delete/{param}', 'UsersController@delete')->name('admin.users.delete');
    });

    Route::group([
        'prefix' => 'creativers'
    ], function($router){
        Route::get('/', 'CreativersController@index')->name('admin.creativers');
        Route::get('/form', 'CreativersController@form')->name('admin.creativers.form');
        Route::get('/form/{param}', 'CreativersController@form')->name('admin.creativers.form_update');
        Route::post('/update/{param}', 'CreativersController@update')->name('admin.creativers.update');
        Route::get('/detail/{param}', 'CreativersController@detail')->name('admin.creativers.detail');
        Route::get('/delete/{param}', 'CreativersController@delete')->name('admin.creativers.delete');
    });
});


Route::get('/get-province', 'Controller@getProvince')->name('get-province');
Route::get('/get-city/{province_id?}', 'Controller@getCity')->name('get-city');
Route::get('/get-district/{regency_id?}', 'Controller@getDistrict')->name('get-district');