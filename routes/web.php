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

Route::get('/', 'HomeController@home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/orders', 'OrdersController@index');
Route::get('/view-order/{id}', 'OrdersController@view');
Route::get('/store/{clientId}/{productId?}', 'ProductsController@store');
Route::get('/store-cat/{clientId}/{categoryId}/{productId?}', 'ProductsController@storeByCategory');
Route::post('/add-to-cart/{id}/{categoryId?}', 'OrdersController@addToCart');
Route::put('/update-cart/{id}', 'OrdersController@updateToCart');
Route::post('/remove-from-cart/{id}/{categoryId?}', 'OrdersController@removeFromCart');
Route::get('/checkout', 'OrdersController@checkout');
Route::post('/go-checkout', 'OrdersController@checkout');
Route::get('/success', 'OrdersController@success');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/users', 'UsersController@index')->name('users');
    Route::get('/clients', 'UsersController@clients')->name('clients');
    Route::get('/add-admin', 'UsersController@add')->name('add-admin');
    Route::post('/save-admin', 'UsersController@add')->name('save-admin');
    Route::get('/edit-user/{id}', 'UsersController@edit');
    Route::post('/switch-user/{id}', 'UsersController@switchActive');
    Route::post('/remove-user/{id}', 'UsersController@remove');

    Route::get('/users/impersonate/{id}', 'UsersController@impersonate')->name('autologin');
    Route::get('/users/stop', 'UsersController@stopImpersonate')->name('stop-autologin');
});

Route::group(['middleware' => ['impersonate', 'auth']], function () {
    Route::get('/profile', 'UsersController@profile');
    Route::get('/profile-edit', 'UsersController@edit');
    Route::post('/save-user/{id}', 'UsersController@edit');

    Route::get('/products', 'ProductsController@index');
    Route::get('/add-product', 'ProductsController@add');
    Route::post('/create-product', 'ProductsController@add');
    Route::get('/edit-product/{id}', 'ProductsController@edit');
    Route::post('/save-product/{id}', 'ProductsController@edit');
    Route::post('/remove-product/{id}', 'ProductsController@remove');
    Route::get('/assign-categories/{id}', 'ProductsController@assign');
    Route::post('/assigning-categories/{id}', 'ProductsController@assign');

    Route::get('/categories', 'CategoriesController@index');
    Route::get('/add-category', 'CategoriesController@add');
    Route::post('/create-category', 'CategoriesController@add');
    Route::get('/edit-category/{id}', 'CategoriesController@edit');
    Route::post('/save-category/{id}', 'CategoriesController@edit');
    Route::post('/remove-category/{id}', 'CategoriesController@remove');
    Route::post('/switch-category/{id}', 'CategoriesController@switchActive');

    Route::get('/client-orders', 'OrdersController@byClient');
    Route::post('/complete-order/{id}', 'OrdersController@complete');

});