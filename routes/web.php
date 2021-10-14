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
Route::post('/logout','AuthController@logout')->name('logout');

Route::group([
    'middleware' => 'auth',
], function($router) {
    Route::get('/', 'DashboardController@index')->name('dashboard'); 

    Route::group([
        'prefix' => 'roles'
    ], function($router){
        Route::get('/', 'RolesController@index')->name('roles');
        Route::get('/form', 'RolesController@form')->name('roles.form');
        Route::post('/create', 'RolesController@create')->name('roles.create');
        Route::get('/form/{param}', 'RolesController@form')->name('roles.form_update');
        Route::post('/update/{param}', 'RolesController@update')->name('roles.update');
        Route::get('/detail/{param}', 'RolesController@detail')->name('roles.detail');
        Route::get('/delete/{param}', 'RolesController@delete')->name('roles.delete');
    });

    Route::group([
        'prefix' => 'users'
    ], function($router){
        Route::get('/', 'UsersController@index')->name('users');
        Route::get('/form', 'UsersController@form')->name('users.form');
        Route::post('/create', 'UsersController@create')->name('users.create');
        Route::get('/form/{param}', 'UsersController@form')->name('users.form_update');
        Route::post('/update/{param}', 'UsersController@update')->name('users.update');
        Route::get('/detail/{param}', 'UsersController@detail')->name('users.detail');
        Route::get('/delete/{param}', 'UsersController@delete')->name('users.delete');
    });
});