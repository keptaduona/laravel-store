<?php

/* ADMIN Routes */

Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/create', 'AdminController@create');
    Route::get('/admin/update', 'AdminController@update');
    Route::get('/admin/create/success', 'AdminController@success');
    Route::get('/admin/reset-products', 'AdminController@reset');
    Route::post('/admin/categories/create', 'CategoryController@create');
    Route::post('/admin/products/create', 'ProductController@create');
    Route::post('/admin/products/update', 'ProductController@update');
    Route::post('/admin/products/delete', 'ProductController@delete');
});

/* ADMIN Public Routes */
Route::get('/admin', 'AdminController@manage');
Route::get('logout', 'SessionsController@destroy');
Route::post('login', 'SessionsController@store');


/* Public get and post routes for backend */
Route::post('/products/byCategory', 'ProductController@getByCategory');
Route::post('/products/getById', 'ProductController@getById');
Route::get('/categories', 'CategoryController@get');
Route::get('/products', 'ProductController@get');
Route::post('/search', 'ProductController@search');

/* Main Public Routes */
Route::get('/store', function () {
    return view('pages.store');
});
Route::get('/', function () {
    return view('pages.index');
});
Route::post('/initsearch', function() {
    return redirect('/store?search='.request('query'));
});
Route::get('/contact', function () {
    return view('pages.contact');
});
Route::get('/about', function () {
    return view('pages.about');
});
