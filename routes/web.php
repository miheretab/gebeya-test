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

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/users', 'UsersController@index');
    Route::get('/clients', 'UsersController@clients');
    Route::get('/add-admin', 'UsersController@add');
    Route::post('/save-admin', 'UsersController@add');
    Route::get('/edit-user/{id}', 'UsersController@edit');
    Route::post('/switch-user/{id}', 'UsersController@switchActive');
    Route::post('/remove-user/{id}', 'UsersController@remove');

    Route::get('/users/impersonate/{id}', 'UsersController@impersonate')->name('autologin');
    Route::get('/users/stop', 'UsersController@stopImpersonate')->name('stop-autologin');
});

Route::group(['middleware' => 'impersonate'], function () {
    Route::get('/profile', 'UsersController@profile');
    Route::get('/profile-edit', 'UsersController@edit');
    Route::post('/save-user/{id}', 'UsersController@edit');


});