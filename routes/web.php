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
    return view('content.content');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//rutas de la categoria
Route::get('/categories','CategoriesController@index');
Route::post('/categories/save','CategoriesController@store');
Route::put('/categories/modify','CategoriesController@update');
Route::put('/categories/active','CategoriesController@active');
Route::put('/categories/desactive','CategoriesController@desactive');
Route::get('/category','CategoriesController@selectCategory');

//rutas de la atractivos
Route::get('/attractives','AttractivesController@index');
Route::post('/attractives/save','AttractivesController@store');
Route::get('/attractives/detail','AttractivesController@detail');
Route::put('/attractives/modify','AttractivesController@update');
Route::put('/attractives/active','AttractivesController@active');
Route::put('/attractives/desactive','AttractivesController@desactive');
